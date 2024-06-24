<?php

namespace App\Http\Controllers\Api\Admin;

use App\Facades\AuthAdmin;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Http\Controllers\ApiController;

class SessionsController extends ApiController
{
    private String $pname = "session";

    public function all()
    {
        return Session::all();
    }

    public function list(Request $request)
    {
        AuthAdmin::can_abort("access_$this->pname");

        $limit = $request->has('limit') ? $request->limit : 10;

        $query = Session::query();

        if ($request->has('search') && !empty($request->search)) {

            $searchText = $request->search;

            $columns = ['name','duration'];

            foreach($columns as $column){
                $query->orWhere($column, 'LIKE', '%' . $searchText . '%');
            }
        }

        $entities = $query->orderBy('id', 'DESC')->paginate($limit);

        return $entities;
    }

    public function edit($id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = Session::findOrFail($id);

        return $entity;
    }

    public function create(Request $request)
    {
        AuthAdmin::can_abort("add_$this->pname");

        $this->validate($request,
         [ "name" => "required|string|max:250" ],
         [ "duration" => "required|numeric" ]
        );

        $data = $request->only('name', 'duration');

        $entity = Session::create($data);

        return $entity;
    }

    public function update(Request $request, $id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = Session::findOrFail($id);

        $this->validate(
            $request,
            ["name" => "required|string|max:250"],
            ["duration" => "required|numeric"]
        );
        $data = $request->only('name', 'duration');

        $entity->update($data);

        return response()->json('Updated Succesfully');
    }

    public function delete($id)
    {
        AuthAdmin::can_abort("delete_$this->pname");

        $entity = Session::findOrFail($id);

        $entity->delete();

        return response()->json('Deleted Succesfully');
    }
}
