<?php

namespace App\Http\Controllers\Api\Admin;

use App\Traits\Uploader;
use App\Facades\AuthAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\GroupTherapist;

class DoctorGroupsController extends ApiController
{
    use Uploader;

    private String $pname = "doctor";



    public function list(Request $request, $id)
    {
        AuthAdmin::can_abort("access_$this->pname");

        $limit = $request->has('limit') ? $request->limit : 10;

        $query = GroupTherapist::where('user_id', $id);

        if ($request->has('search') && !empty($request->search)) {

            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $entities = $query->orderBy('id', 'DESC')->paginate($limit);
        return $entities;
    }



    public function edit($id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = GroupTherapist::findOrFail($id);
        return $entity;
    }



    public function create(Request $request, $id)
    {
        AuthAdmin::can_abort("add_$this->pname");

        $this->validate($request, [
            "title" => "required|string|max:300",
            "desc" => "nullable|string|max:10000",
            "date" => "required|date",
            "seats" => "required|integer",
            "start_time" => "required|date_format:H:i",
            "finish_time" => "required|date_format:H:i|after:start_time",
        ]);

        $data = $request->only('title', 'desc', 'date', 'seats', 'start_time', 'finish_time');
        $data['user_id'] = $id;
        $entity = GroupTherapist::create($data);
        return $entity;
    }

    public function update(Request $request, $id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = GroupTherapist::findOrFail($id);

        $this->validate($request, [
            "title" => "required|string|max:300",
            "desc" => "nullable|string|max:10000",
            "date" => "required|date",
            "seats" => "required|integer",
            "start_time" => "required|regex:/^\d{1,2}:\d{1,2}(:\d{1,2})?$/",
            "finish_time" => "required|regex:/^\d{1,2}:\d{1,2}(:\d{1,2})?$/|after:start_time",
        ]);


        $data = $request->only('title', 'desc', 'date', 'seats', 'start_time', 'finish_time');

        $entity->update($this->removeNull($data));

        return response()->json('Updated Succesfully');
    }

    public function delete($userID, $id)
    {
        AuthAdmin::can_abort("delete_$this->pname");

        $entity = GroupTherapist::where('user_id', $userID)->where('id', $id);

        $entity->delete();

        return response()->json('Deleted Succesfully');
    }

    private function removeNull($arr)
    {
        foreach ($arr as &$value) {
            if ($value === 'null') {
                $value = null;
            }
        }

        return $arr;
    }
}
