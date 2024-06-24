<?php

namespace App\Http\Controllers\Api\Mobile;

use Illuminate\Support\Facades\Validator;

use App\Http\Resources\{
    DoctorDetailsResource,
    DashboardDoctorResource,
    DashboardCategoryResource,
    SlotRangeResource,
    DoctorGroupsResource
};
use App\Models\{User, Category, SlotRange};
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class DashboardController extends ApiController
{
    public function menu(Request $request)
    {
        $categories = Category::whereNull('parent_id')
            ->when($request->has('parent_id'), function ($query) use ($request) {
                $parentId = $request->parent_id;

                $query->whereHas('children', function ($query) use ($parentId) {
                    $query->where('parent_id', $parentId);
                });
            })->get();

        return DashboardCategoryResource::collection($categories?->load('children'));
    }

    public function home(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;

        $page = $request->has('page') ? $request->page : 1;

        $offset =  $limit * ($page - 1);

        $count = User::role('doctor')->count();

        $doctors = User::role('doctor')->orderBy('id', 'DESC')->skip($offset)->take($limit)->get();

        return [
            'total_size' => $count,
            'limit' => $limit,
            'offset' => $page,
            'doctors' => DashboardDoctorResource::collection($doctors),
        ];
    }

    public function search(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;

        $page = $request->has('page') ? $request->page : 1;

        $offset =  $limit * ($page - 1);

        $count = User::role('doctor')->count();

        $query = User::query();

        if ($request->has('search') && !empty($request->search)) {

            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $query->where('user_type', 'doctor');

        $doctors = $query->orderBy('id', 'DESC')->skip($offset)->take($limit)->get();

        return [
            'total_size' => $count,
            'limit' => $limit,
            'offset' => $page,
            'doctors' => DashboardDoctorResource::collection($doctors),
        ];
    }

    public function doctorById($id)
    {
        $relations = [
            'doctorProfile', 'categories', 'ageGroups', 'workingStyles',
            'specialties', 'qualifications', 'speakingLanguages'
        ];

        $doctor = User::with($relations)->where('user_type', 'doctor')->find($id);

        $currentDay = \Carbon\Carbon::now()->format('l');
        $slots =  SlotRange::whereHas('slot', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->where('day', $currentDay)->get(['time_from', 'time_to', 'day']);


        $doctor->slots = $slots;

        return DoctorDetailsResource::make($doctor);
    }

    public function doctorsByCategory(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 10;

        $page = $request->has('page') ? $request->page : 1;

        $offset =  $limit * ($page - 1);

        $doctors = User::doctorType()
            ->orderBy('id', 'DESC')
            ->when($request->has('category_id'), function ($query) use ($request) {
                $categoryId = $request->category_id;

                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                });
            })->skip($offset)->take($limit)
            ->get();

        return [
            'total_size' => $doctors->count(),
            'limit' => $limit,
            'offset' => $page,
            'doctors' => DashboardDoctorResource::collection($doctors),
        ];
    }

    public function slots(Request $request)
    {
        $rules = [
            'date' => 'required|date_format:d-m-Y',
            'user_id' => 'required|exists:users,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'msg' => $validator->errors(),
                    'status' => false
                ],
                400
            );
        }

        $date = \Carbon\Carbon::parse($request->date);
        $dayName = $date->format('l');
        $slots =  SlotRange::whereHas('slot', function ($query) use ($request) {
            $query->where('user_id', $request->user_id);
        })->where('day', $dayName)->get(['id', 'time_from', 'time_to', 'day']);

        return SlotRangeResource::collection($slots)->additional(['date' => $request->date]);
    }

    public function doctorGroups($id = null)
    {
        if (!$id) {
            return response()->json([
                'msg' => 'Please pass the user id', 'status' => false
            ]);
        } else {
            $doctorGroups = User::where('id', $id)
                ->whereHas('doctorProfile')
                ->with(['doctorProfile', 'groupTherapists'])
                ->first();
        }

        if (!$doctorGroups) {
            return response()->json([
                'msg' => 'This user is not a doctor.',
                'status' => false
            ], 400);
        }

        return DoctorGroupsResource::make($doctorGroups);
    }
}
