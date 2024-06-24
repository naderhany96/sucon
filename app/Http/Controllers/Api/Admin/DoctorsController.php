<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\Slot;
use App\Models\User;
use App\Models\Media;
use App\Models\Category;
use App\Traits\Uploader;
use App\Facades\AuthAdmin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class DoctorsController extends ApiController
{
    use Uploader;

    private String $pname = "doctor";

    public function extra()
    {
        $qualifications     = DB::table('qualifications')->select('id', 'name')->get();
        $specialties        = DB::table('specialties')->select('id', 'name')->get();
        $age_groups         = DB::table('age_groups')->select('id', 'range')->get();
        $speaking_languages = DB::table('speaking_languages')->select('id', 'lang')->get();
        $working_styles     = DB::table('working_styles')->select('id', 'name')->get();
        $categories         = Category::childrensOnly()->get();

        return [
            'qualifications' => $qualifications,
            'specialties' => $specialties,
            'age_groups' => $age_groups,
            'speaking_languages' => $speaking_languages,
            'working_styles' => $working_styles,
            'categories' => $categories,
        ];
    }

    public function list(Request $request)
    {
        AuthAdmin::can_abort("access_$this->pname");

        $limit = $request->has('limit') ? $request->limit : 10;

        $query = User::where('user_type', 'doctor');

        if ($request->has('search') && !empty($request->search)) {

            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $entities = $query->orderBy('id', 'DESC')->paginate($limit);

        return $entities;
    }

    public function edit($id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = User::role('doctor')->with([
            'doctorProfile',
            'categories',
            'ageGroups',
            'workingStyles',
            'specialties',
            'qualifications',
            'speakingLanguages',
        ])->findOrFail($id);

        return $entity;
    }


    public function updateSlot(Request $request, $id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = User::with('doctorProfile')->findOrFail($id);

        $timeSlots = json_decode($request->input('timeSlots'), true);

        User::where('id', $id)->update(['time_zone_id' => $request->timeZoneId]);

        $updatedUserTimeZone = User::find($id);

        // Start the transaction
        DB::beginTransaction();

        try {

            $entity->doctorProfile?->update(['price' => $request->price]);
            $slot = Slot::where('user_id', $id)->delete();

            foreach ($timeSlots as $slot) {
                $day = $slot['day'];
                foreach ($slot['slots'] as $timeSlot) {
                    if (!empty($timeSlot['timeFrom']) && !empty($timeSlot['timeTo'])) {

                        $validatedData = Validator::make([
                            'time_from' => $timeSlot['timeFrom'],
                            'time_to' => $timeSlot['timeTo'],
                        ], [
                            'time_from' => 'required|regex:/^\d{1,2}:\d{1,2}(:\d{1,2})?$/',
                            'time_to' => 'required|regex:/^\d{1,2}:\d{1,2}(:\d{1,2})?$/|after:time_from',
                        ])->validate();

                        $validatedSlots[] = [
                            'timeFrom' => $validatedData['time_from'],
                            'timeTo' => $validatedData['time_to'],
                            'day' => $slot['day'],
                        ];


                        // Convert time to UTC
                        $format = strlen($timeSlot['timeFrom']) > 5 ? 'H:i:s' : 'H:i';


                        $timeFromUTC = Carbon::parse($timeSlot['timeFrom'])->createFromFormat($format, $timeSlot['timeFrom'], $updatedUserTimeZone->timeZone?->name)->setTimezone('UTC');

                        $timeToUTC = Carbon::parse($timeSlot['timeTo'])->createFromFormat($format, $timeSlot['timeTo'], $updatedUserTimeZone->timeZone?->name)->setTimezone('UTC');

                        $doctorSlot = new Slot();
                        $doctorSlot->user_id   = $id;
                        $doctorSlot->day       = $day;
                        $doctorSlot->range     = $request->range;
                        $doctorSlot->time_from = $timeFromUTC->format('H:i:s');
                        $doctorSlot->time_to   = $timeToUTC->format('H:i:s');
                        $doctorSlot->save();


                        // Calculate time intervals
                        $interval = $request->range; // in minutes
                        $start = $timeFromUTC;
                        $end = $timeToUTC;
                        $ranges = [];
                        while ($start < $end) {
                            $ranges[] = [
                                'doctor_slot_id' => $doctorSlot->id,
                                'time_from' => $start->format('H:i:s'),
                                'time_to' => $start->addMinutes($interval)->format('H:i:s'),
                                'day' => $day,
                                'created_at' => now()
                            ];
                        }

                        // Insert data into slot_ranges table
                        DB::table('slot_ranges')->insert($ranges);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }






        return response()->json('Updated Succesfully');
    }



    public function editSlot($id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        // Find the user with the given $id
        $entity = User::role('doctor')->with(['slots','doctorProfile'])->findOrFail($id);

        // Get the user's time zone
        $userTimeZone = $entity->timeZone?->name;

        $entity->slotss = $entity->slots->map(function ($item) use ($userTimeZone) {
            // Convert the time from the user's time zone to the server's time zone


            $timeFrom = Carbon::createFromFormat('H:i:s', $item->time_from, 'UTC')->setTimezone($userTimeZone);
            $timeTo   = Carbon::createFromFormat('H:i:s', $item->time_to, 'UTC')->setTimezone($userTimeZone);

            return [
                'timeFrom' => $timeFrom->format('H:i:s'),
                'timeTo' => $timeTo->format('H:i:s'),
                'day' => $item->day,
                'range' => $item->range
            ];
        })->groupBy('day');

        return $entity;
    }





    public function create(Request $request)
    {
        AuthAdmin::can_abort("add_$this->pname");

        $this->validate($request, [
            "email" => [
                'required',
                'email',
                Rule::unique('users', 'email')->where('user_type', 'doctor')->whereNull('deleted_at')
            ],
            "phone" => [
                'required',
                'between:1,15',
                Rule::unique('users', 'phone')->where('user_type', 'doctor')->whereNull('deleted_at')
            ],

            "surname" => "nullable|string|max:250",
            "name" => "nullable|string|max:250",
            "gender" => "nullable|string",
            "dob" => "nullable|string",

            "about" => "nullable|string|max:200",
            "price" => "nullable|string|max:200",
            "yoe" => "nullable|string|max:200",

            "age_group_ids" => "nullable|string",
            "qualification_ids" => "nullable|string",
            "specialty_ids" => "nullable|string",
            "working_style_ids" => "nullable|string",
            "speaking_language_ids" => "nullable|string",
            "category_ids" => "nullable|string",

            'avatar' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|mimes:mp4,mpg,mpeg,ogv,ogg,webm|max:20000',
            'passport' => 'nullable|mimes:jpeg,png,jpg|max:10000',
            'cover_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'license' => 'nullable|mimes:pdf|max:10000',
        ]);

        $data = $request->only('surname', 'name', 'email', 'phone', 'gender', 'dob');

        $data['password'] = bcrypt(Str::random(10));
        $data['user_type'] = 'doctor';

        if ($request->email_verified == 1 || $request->email_verified == 'true')
            $data['email_verified_at'] = now();

        $entity = User::create($data);

        $entity->assignRole('doctor');

        $doctorProfile = new DoctorProfile;
        $doctorProfile->about = $request->about ?? null;
        $doctorProfile->price = $request->price ?? null;
        $doctorProfile->yoe = $request->yoe ?? null;

        $entity->doctorProfile()->save($doctorProfile);

        // relations
        if ($request->filled('category_ids'))
            $entity->categories()->sync(explode(",", $request->category_ids));

        if ($request->filled('qualification_ids'))
            $entity->qualifications()->sync(explode(",", $request->qualification_ids));

        if ($request->filled('specialty_ids'))
            $entity->specialties()->sync(explode(",", $request->specialty_ids));

        if ($request->filled('age_group_ids'))
            $entity->ageGroups()->sync(explode(",", $request->age_group_ids));

        if ($request->filled('working_style_ids'))
            $entity->workingStyles()->sync(explode(",", $request->working_style_ids));

        if ($request->filled('speaking_language_ids'))
            $entity->speakingLanguages()->sync(explode(",", $request->speaking_language_ids));

        // files
        if ($request->hasFile('avatar'))
            $this->uploads($entity, $request->file('avatar'), 'avatars', 'avatar');

        if ($request->hasFile('video'))
            $this->uploads($doctorProfile, $request->file('video'), 'videos', 'video');

        if ($request->hasFile('passport'))
            $this->uploads($doctorProfile, $request->file('passport'), 'passports', 'passport');

        if ($request->hasFile('cover_image'))
            $this->uploads($doctorProfile, $request->file('cover_image'), 'cover_images', 'cover_image');

        if ($request->hasFile('license'))
            $this->uploads($doctorProfile, $request->file('license'), 'licenses', 'license');

        return $entity;
    }

    public function update(Request $request, $id)
    {
        AuthAdmin::can_abort("edit_$this->pname");

        $entity = User::with('doctorProfile')->findOrFail($id);

        $this->validate($request, [
            "email" => [
                'required',
                'email',
                Rule::unique('users', 'email')->where('user_type', 'doctor')->whereNull('deleted_at')->ignore($id)
            ],
            "phone" => [
                'required',
                'between:1,15',
                Rule::unique('users', 'phone')->where('user_type', 'doctor')->whereNull('deleted_at')->ignore($id)
            ],

            "surname" => "nullable|string|max:250",
            "name" => "nullable|string|max:250",
            "gender" => "nullable|string",
            "dob" => "nullable|string",

            "about" => "nullable|string|max:200",
            "price" => "nullable|string|max:200",
            "yoe" => "nullable|string|max:200",

            "age_group_ids" => "nullable|string",
            "qualification_ids" => "nullable|string",
            "specialty_ids" => "nullable|string",
            "working_style_ids" => "nullable|string",
            "speaking_language_ids" => "nullable|string",

            'avatar' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|mimes:mp4,mpg,mpeg,ogv,ogg,webm|max:20000',
            'passport' => 'nullable|mimes:jpeg,png,jpg|max:10000',
            'cover_image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'license' => 'nullable|mimes:pdf|max:10000',
        ]);

        $data = $request->only('surname', 'name', 'email', 'phone', 'gender', 'dob');

        if ($request->email_verified == 1 || $request->email_verified == 'true') {
            $data['email_verified_at'] = now();
        } else {
            $data['email_verified_at'] = null;
        }

        $entity->update($this->removeNull($data));

        $doctorProfile = DoctorProfile::find($entity->doctorProfile->id);

        $profileData = $request->only('about', 'price', 'yoe');

        $doctorProfile->update($this->removeNull($profileData));

        // relations
        if ($request->filled('category_ids'))
            $entity->categories()->sync(explode(",", $request->category_ids));
        else
            $entity->categories()->detach();

        if ($request->filled('qualification_ids'))
            $entity->qualifications()->sync(explode(",", $request->qualification_ids));
        else
            $entity->qualifications()->detach();

        if ($request->filled('specialty_ids'))
            $entity->specialties()->sync(explode(",", $request->specialty_ids));
        else
            $entity->specialties()->detach();

        if ($request->filled('age_group_ids'))
            $entity->ageGroups()->sync(explode(",", $request->age_group_ids));
        else
            $entity->ageGroups()->detach();

        if ($request->filled('working_style_ids'))
            $entity->workingStyles()->sync(explode(",", $request->working_style_ids));
        else
            $entity->workingStyles()->detach();

        if ($request->filled('speaking_language_ids'))
            $entity->speakingLanguages()->sync(explode(",", $request->speaking_language_ids));
        else
            $entity->speakingLanguages()->detach();

        // files
        if ($request->hasFile('avatar')) {
            $this->deleteIfExist($entity, 'avatar');
            $this->uploads($entity, $request->file('avatar'), 'avatars', 'avatar');
        }

        if ($request->hasFile('video')) {
            $this->deleteIfExist($doctorProfile, 'video');
            $this->uploads($doctorProfile, $request->file('video'), 'videos', 'video');
        }

        if ($request->hasFile('passport')) {
            $this->deleteIfExist($doctorProfile, 'passport');
            $this->uploads($doctorProfile, $request->file('passport'), 'passports', 'passport');
        }

        if ($request->hasFile('cover_image')) {
            $this->deleteIfExist($doctorProfile, 'cover_image');
            $this->uploads($doctorProfile, $request->file('cover_image'), 'cover_images', 'cover_image');
        }

        if ($request->hasFile('license')) {
            $this->deleteIfExist($doctorProfile, 'license');
            $this->uploads($doctorProfile, $request->file('license'), 'licenses', 'license');
        }

        return response()->json('Updated Succesfully');
    }

    public function delete($id)
    {
        AuthAdmin::can_abort("delete_$this->pname");

        $entity = User::role('doctor')->findOrFail($id);

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
