<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Media;
use App\Models\Category;
use App\Traits\Uploader;
use App\Facades\AuthAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoriesController extends ApiController
{
    use Uploader;

    private String $pname = "category";
    
    public function extra()
    {
        $categories = Category::parenstOnly()->get();

        return [
            'parent_categries' => $categories,
        ];
    }

    public function list(Request $request)
    {
        AuthAdmin::can_abort("access_$this->pname");

        $limit = $request->has('limit') ? $request->limit : 10;

        $query = Category::with('parent');

        if ($request->has('search') && !empty($request->search)) {

            $searchText = $request->search;

            $columns = ['name'];

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

        $entity = Category::with('media')->findOrFail($id);

        return $entity;
    }

    public function create(Request $request)
    {
        AuthAdmin::can_abort("add_$this->pname");

        $this->validate($request, [ 
            "name" => "required|string|max:250", 
            "parent" => "nullable|integer|exists:categories,id", 
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data['name'] = $request->name;

        if ($request->filled('parent')) $data['parent_id'] = $request->parent;
        
        $entity = Category::create($data);

        if ($request->hasFile('image') && !$request->filled('parent')) {
            $this->uploads($entity, $request->file('image'), 'categories', 'image');
        }

        return $entity;
    }
    
    public function update(Request $request, $id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = Category::findOrFail($id);

        $this->validate($request, [ 
            "name" => "required|string|max:250", 
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data['name'] = $request->name;
        
        $entity->update($data);

        if ($request->hasFile('image') && !$request->filled('parent')) {
            $this->deleteIfExist($entity, 'image');
            $this->uploads($entity, $request->file('image'), 'categories', 'image');
        }

        return response()->json('Updated Succesfully');
    }

    public function delete($id)
    {
        AuthAdmin::can_abort("delete_$this->pname");

        $entity = Category::findOrFail($id);
    
        $entity->delete();

        return response()->json('Deleted Succesfully');
    }

    public function deleteMedia($id)
    {
        Media::findOrFail($id)->delete();
    }

}
