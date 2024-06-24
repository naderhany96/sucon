<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::all()->pluck('name');
        return response()->json(['permissions' => $permissions]);
    }

    public function all()
    {
        $permissions = Permission::all();
        return response()->json(['permissions' => $permissions]);
    }

    public function show(int $permission)
    {

        $permission = Permission::findById($permission);

        $users = Admin::permission($permission->name)->get();
        
        return response()->json(['name' => $permission->name, 'permission_users' => $users]);
    }

    public function store(Request $request)
    {

        foreach(explode(',', $request->permissions) as $permission)
        {
            Permission::create(['name' => $permission]);
        }

        return response()->json('Created Succesfully');
    }

    public function update(Request $request,int $id)
    {
        $request = $request->validated();
        $name = $request['permission'];
        $permission = Permission::findById($id);
        $permission->name = $name;
        $permission->save();
        return response()->json('Updated Succesfully');
    }

    public function delete(int $permission)
    {
        $permission = Permission::findById($permission);
        $permission->delete();
        return response()->json('Deleted Succesfully');
    }


    public function assignPermission(Request $request, int $id)
    {
        $admin = Admin::findOrFail($id);
        return $admin->givePermissionTo(explode(',', $request->permissions));
    }


    public function permissionsForAdmin(Request $request, int $id)
    {
        $admin = Admin::findOrFail($id);
        return $admin->getAllPermissions();
    }
}
