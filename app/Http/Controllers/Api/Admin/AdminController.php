<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use App\Facades\AuthAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class AdminController extends ApiController
{
    private String $pname = "admin";

    public function list(Request $request)
    {
        AuthAdmin::can_abort("access_$this->pname");

        $authUser = AuthAdmin::user();

        $limit = $request->has('limit') ? $request->limit : 10;

        $query = Admin::query();

        if ($authUser->isSuperAdmin != 1) {
            $query->notSuperAdmin();
        }

        if ($request->has('search') && !empty($request->search)) {

            $searchText = $request->search;

            $columns = ['name', 'email', 'mobile_phone'];

            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $searchText . '%');
            }
        }

        $admins = $query->orderBy('id', 'DESC')->paginate($limit);

        return $admins;
    }

    public function edit($id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $admin = Admin::findOrFail($id);

        $authUser = AuthAdmin::user();
        // prevent normal admin try to edit super admin
        if ($authUser->isSuperAdmin == 0 && $admin->isSuperAdmin == 1) {
            AuthAdmin::can_abort('hack');
        }

        $permissions = $admin->getPermissionNames();

        return ["admin" => $admin, "permissions" => $permissions];
    }

    public function create(Request $request)
    {

        AuthAdmin::can_abort("add_$this->pname");

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:admins,email',
            'mobile_phone' => 'required',
            'password' => 'required',
            'isActive' => 'nullable',
            'permissions' => 'nullable',
        ]);

        $data = $request->only('name', 'email', 'mobile_phone', 'password', 'isActive');

        $data['password'] = bcrypt($data['password']);

        if (AuthAdmin::can("active_admin")) {
            // change account status
            $data['isActive'] = $data['isActive'] == 'true' || $data['isActive'] == '1' ? 1 : 0;
        } else {
            // account status will always be deactivated
            $data['isActive'] = 0;
        }

        $admin = Admin::create($data);

        if (
            AuthAdmin::can('admin_permissions') &&
            isset($request->permissions) &&
            !empty($request->permissions)
        ) {
            $permissions = explode(",", $request->permissions);

            if (is_array($permissions) && count($permissions) > 0) {
                $admin->insertPermissions($permissions);
            }
        }

        return $admin;
    }

    public function update(Request $request, $id)
    {

        AuthAdmin::can_abort("edit_$this->pname");

        $authUser = AuthAdmin::user();

        $admin = Admin::findOrFail($id);

        // prevent normal admin try to update super admin
        if ($authUser->isSuperAdmin == 0 && $admin->isSuperAdmin == 1) {
            AuthAdmin::can_abort('hack');
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:admins,email,' . $id,
            'mobile_phone' => 'required',
            'isActive' => 'nullable',
            'permissions' => 'nullable',
        ]);

        $data = $request->only('name', 'email', 'mobile_phone', 'password', 'isActive');

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        if (AuthAdmin::can("active_admin")) {
            // change account status
            $data['isActive'] = $data['isActive'] == 'true' || $data['isActive'] == '1' ? 1 : 0;
        } else {
            // don't change account status
            $data['isActive'] = $admin->isActive;
        }

        $admin->update($data);

        if (
            AuthAdmin::can('admin_permissions') &&
            isset($request->permissions) &&
            !empty($request->permissions)
        ) {
            $permissions = explode(",", $request->permissions);

            if (is_array($permissions) && count($permissions) > 0) {
                $admin->syncPermissions($permissions);
            }
        }

        return response()->json('Updated Succesfully');
    }

    public function delete($id)
    {
        AuthAdmin::can_abort("delete_$this->pname");

        $authUser = AuthAdmin::user();
        $admin = Admin::findOrFail($id);

        // prevent normal admin try to delete super admin
        if ($authUser->isSuperAdmin == 0 && $admin->isSuperAdmin == 1) {
            AuthAdmin::can_abort('hack');
        }

        // don't delete your self
        if ($authUser->id != $id) {
            // not first super admin
            if ($admin->id != 1) {
                $admin->delete();
            }
        }

        return response()->json('Deleted Succesfully');
    }
}
