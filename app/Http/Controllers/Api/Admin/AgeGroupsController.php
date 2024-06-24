<?php

namespace App\Http\Controllers\Api\Admin;

use App\Facades\AuthAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\AgeGroup;

class AgeGroupsController extends ApiController
{
    private String $pname = "age_group";

    public function all()
    {
        return AgeGroup::all();
    }

    public function list(Request $request)
    {
        AuthAdmin::can_abort("access_$this->pname");

        $limit = $request->has('limit') ? $request->limit : 10;

        $query = AgeGroup::query();

        if ($request->has('search') && !empty($request->search)) {

            $searchText = $request->search;

            $columns = ['range'];

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

        $entity = AgeGroup::findOrFail($id);

        return $entity;
    }

    public function create(Request $request)
    {
        AuthAdmin::can_abort("add_$this->pname");

        $this->validate($request, [ 
            "from" => "required|string|max:250",
            "to" => "required|string|max:250"
        ]);

        $data = $request->only('from','to');

        $data['range'] = $data['to'] == '+' ? $data['from'] . '+' : $data['from'] . '-' . $data['to'];
        
        $entity = AgeGroup::create($data);

        return $entity;
    }
    
    public function update(Request $request, $id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = AgeGroup::findOrFail($id);

        $this->validate($request, [ 
            "from" => "required|string|max:250",
            "to" => "required|string|max:250"
        ]);

        $data = $request->only('from','to');

        $data['range'] = $data['to'] == '+' ? $data['from'] . '+' : $data['from'] . '-' . $data['to'];
        
        $entity->update($data);

        return response()->json('Updated Succesfully');
    }

    public function delete($id)
    {
        AuthAdmin::can_abort("delete_$this->pname");

        $entity = AgeGroup::findOrFail($id);
    
        $entity->delete();

        return response()->json('Deleted Succesfully');
    }
}
