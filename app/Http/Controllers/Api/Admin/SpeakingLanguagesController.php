<?php

namespace App\Http\Controllers\Api\Admin;

use App\Facades\AuthAdmin;
use Illuminate\Http\Request;
use App\Models\SpeakingLanguage;
use App\Http\Controllers\ApiController;

class SpeakingLanguagesController extends ApiController
{
    private String $pname = "speaking_language";

    public function all()
    {
        return SpeakingLanguage::all();
    }

    public function list(Request $request)
    {
        AuthAdmin::can_abort("access_$this->pname");

        $limit = $request->has('limit') ? $request->limit : 10;

        $query = SpeakingLanguage::query();

        if ($request->has('search') && !empty($request->search)) {

            $searchText = $request->search;

            $columns = ['lang'];

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

        $entity = SpeakingLanguage::findOrFail($id);

        return $entity;
    }

    public function create(Request $request)
    {
        AuthAdmin::can_abort("add_$this->pname");

        $this->validate($request, [ "lang" => "required|string|max:250" ]);

        $data = $request->only('lang');
        
        $entity = SpeakingLanguage::create($data);

        return $entity;
    }
    
    public function update(Request $request, $id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = SpeakingLanguage::findOrFail($id);

        $this->validate($request, [ "lang" => "required|string|max:250" ]);

        $data = $request->only('lang');
        
        $entity->update($data);

        return response()->json('Updated Succesfully');
    }

    public function delete($id)
    {
        AuthAdmin::can_abort("delete_$this->pname");

        $entity = SpeakingLanguage::findOrFail($id);
    
        $entity->delete();

        return response()->json('Deleted Succesfully');
    }
}
