<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Media;
use App\Traits\Uploader;
use App\Facades\AuthAdmin;
use Illuminate\Http\Request;
use App\Models\PatientProfile;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ApiController;

class PatientsController extends ApiController
{
    use Uploader;
    
    private String $pname = "patient";

    public function list(Request $request)
    {
        AuthAdmin::can_abort("access_$this->pname");

        $limit = $request->has('limit') ? $request->limit : 10;

        $query = User::query();

        if ($request->has('search') && !empty($request->search)) {

            $query->orWhere('name', 'LIKE', '%' . $request->search . '%');
        }

        $query->where('user_type','patient');

        $entities = $query->orderBy('id', 'DESC')->paginate($limit);

        return $entities;
    }

    public function edit($id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = User::with('patientProfile')->role('patient')->findOrFail($id);

        return $entity;
    }

    public function create(Request $request)
    {
        AuthAdmin::can_abort("add_$this->pname");


        $this->validate($request, [
            "email" => [
                'required',
                'email', Rule::unique('users', 'email')->where('user_type', 'patient')->whereNull('deleted_at')
            ],
            "phone" => [
                'required',
                'between:1,15',
                Rule::unique('users', 'phone')->where('user_type', 'patient')->whereNull('deleted_at')
            ],
            'password' => 'required|min:6',

            "surname" => "nullable|string|max:250",
            "name" => "nullable|string|max:250",
            "gender" => "nullable|string",
            "dob" => "nullable|string",
        ]);

        $data = $request->only('surname', 'name', 'email', 'phone', 'gender', 'dob','password');

        $data['password'] = bcrypt($data['password']);
        $data['user_type'] = 'patient';

        if ($request->email_verified == 1 || $request->email_verified == 'true')
            $data['email_verified_at'] = now();

        $entity = User::create($data);

        $entity->assignRole('patient');

        $patientProfile = new PatientProfile;

        $entity->patientProfile()->save($patientProfile);

        // files
        if ($request->hasFile('avatar')) {
            $this->validate($request, ['avatar' => 'nullable|mimes:jpeg,png,jpg|max:2048']);
            $this->uploads($entity, $request->file('avatar'), 'avatars', 'avatar');
        }

        return $entity;
    }
    
    public function update(Request $request, $id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = User::role('patient')->findOrFail($id);

        $this->validate($request, [
            "email" => [
                'required',
                'email', Rule::unique('users', 'email')->where('user_type','patient')->whereNull('deleted_at')->ignore($id)
            ],
            "phone" => [
                'required',
                'between:1,15',
                Rule::unique('users', 'phone')->where('user_type','patient')->whereNull('deleted_at')->ignore($id)
            ],
            'password' => 'nullable|min:6',

            "surname" => "nullable|string|max:250",
            "name" => "nullable|string|max:250",
            "gender" => "nullable|string",
            "dob" => "nullable|string",
        ]);

        $data = $request->only('surname', 'name', 'email', 'phone', 'gender', 'dob','password');
        
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        if ($request->email_verified == 1 || $request->email_verified == 'true'){
            $data['email_verified_at'] = now();
        } else {
            $data['email_verified_at'] = null;
        }
        
        $entity->update($this->removeNull($data));
        
        // files
        if ($request->hasFile('avatar')) {
            $this->validate($request, ['avatar' => 'nullable|mimes:jpeg,png,jpg|max:2048']);
            $this->deleteIfExist($entity, 'avatar');
            $this->uploads($entity, $request->file('avatar'), 'avatars', 'avatar');
        }

        return response()->json('Updated Succesfully');
    }

    public function delete($id)
    {
        AuthAdmin::can_abort("delete_$this->pname");

        $entity = User::role('patient')->findOrFail($id);
    
        $entity->delete();

        return response()->json('Deleted Succesfully');
    }
    
    public function deleteMedia($id)
    {
        Media::findOrFail($id)->delete();
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
