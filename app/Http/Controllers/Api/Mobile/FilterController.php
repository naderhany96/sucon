<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Models\Slot;
use App\Models\Session;
use App\Models\YOERange;
use App\Models\Specialty;
use App\Models\PriceRange;
use Illuminate\Http\Request;
use App\Models\SpeakingLanguage;
use App\Http\Controllers\ApiController;
use App\Http\Requests\FindExpertRequest;
use App\Http\Resources\DashboardDoctorResource;
use App\Http\Resources\FiltersCategoryResource;
use App\Models\{User, AgeGroup, Category, Qualification, SessionRange, WorkingStyle};

class FilterController extends ApiController
{

    public function findExpert(FindExpertRequest $request)
    {
        $limit = $request->has('limit') ? $request->limit : "10";

        $page = $request->has('page') ? $request->page : "1";

        $offset =  $limit * ($page - 1);


        $query = User::doctorType();

        if ($request->has('gender') && !empty($request->gender)) $query->whereIn('gender', $request->gender);

        if ($request->has('categories') && !empty($request->categories)) {
            $categories = $request->categories;
            $query->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('category_id', $categories);
            });
        }

        if ($request->has('languages') && !empty($request->languages)) {
            $languages = $request->languages;
            $query->whereHas('speakingLanguages', function ($q) use ($languages) {
                $q->whereIn('lang_id', $languages);
            });
        }

        if ($request->has('age_groups') && !empty($request->age_groups)) {
            $age_groups = $request->age_groups;
            $query->whereHas('ageGroups', function ($q) use ($age_groups) {
                $q->whereIn('age_group_id', $age_groups);
            });
        }

        if ($request->has('session_range') && !empty($request->session_range)) {

            $sessionRangeIds = (array) $request->input('session_range');

            $sessionRanges = sessionRange::whereIn('id', $sessionRangeIds)
                ->pluck('from', 'to')
                ->toArray();

            $minRange = min(array_values($sessionRanges));
            $maxRange = max(array_keys($sessionRanges));


            $query->whereHas('slots', function ($q) use ($minRange, $maxRange) {
                $q->where('time_from', '>=', $minRange)
                    ->where('time_to', '<=', $maxRange);
            });
        }

        if ($request->has('price_range') && !empty($request->price_range)) {
            $priceRangeIds = (array) $request->input('price_range');

            $priceRanges = PriceRange::whereIn('id', $priceRangeIds)
                ->pluck('from', 'to')
                ->toArray();

            $minPrice = min(array_values($priceRanges));
            $maxPrice = max(array_keys($priceRanges));

            $priceRangeValues = [$minPrice, $maxPrice];
            $query->whereHas('doctorProfile', function ($q) use ($priceRangeValues) {
                $q->whereBetween('price', $priceRangeValues);
            });
        }


        $doctors = $query->skip($offset)->take($limit)->get();

        return [
            'total_size' => $doctors->count(),
            'limit' => $limit,
            'offset' => $page,
            'doctors' => DashboardDoctorResource::collection($doctors),
        ];
    }

    public function findExpert2(Request $request)
    {


        $limit = $request->has('limit') ? $request->limit : "10";
        $page = $request->has('page') ? $request->page : "1";
        $offset =  $limit * ($page - 1);
        $query = User::doctorType();

        if ($request->has('availability') && !empty($request->availability)) {
            $query->whereHas('slots.slotRanges', function ($q) use ($request) {
                $q->where('time_from', '>=', now())
                    ->where('created_at', '>=', now());
            });
        }

        if ($request->has('intro_video') && !empty($request->intro_video)) {
            $query->whereHas('media', function ($q) use ($request) {
                $q->where('attribute', 'video');
            });
        }

        if ($request->has('reviews') && !empty($request->reviews && $request->reviews == 1))
            $query->has('ratings');

        if ($request->has('gender') && !empty($request->gender))
            $query->whereIn('gender', $request->gender);

        if ($request->has('languages') && !empty($request->languages)) {
            $languages = $request->languages;
            $query->whereHas('speakingLanguages', function ($q) use ($languages) {
                $q->whereIn('lang_id', $languages);
            });
        }

        if ($request->has('qualifications') && !empty($request->qualifications)) {
            $qualifications = $request->qualifications;
            $query->whereHas('qualifications', function ($q) use ($qualifications) {
                $q->whereIn('qualification_id', $qualifications);
            });
        }

        if ($request->filled('min_age')) {
            $minDate = now()->subYears($request->input('min_age'))->format('Y-m-d');

            $query->where('dob', '<=', $minDate);
        }


        if ($request->filled('max_age')) {
            $maxDate = now()->subYears($request->input('max_age'))->format('Y-m-d');

            $query->where('dob', '>=', $maxDate);
        }



        if ($request->has('yoe_range') && !empty($request->yoe_range)) {
            $yoeRangeIds = (array) $request->input('yoe_range');

            $yoeRanges = YOERange::whereIn('id', $yoeRangeIds)
                ->pluck('from', 'to')
                ->toArray();

            $minYoe = min(array_values($yoeRanges));
            $maxYoe = max(array_keys($yoeRanges));

            $yoeRangeValues = [$minYoe, $maxYoe];
            $query->whereHas('doctorProfile', function ($q) use ($yoeRangeValues) {
                $q->whereBetween('yoe', $yoeRangeValues);
            });
        }

        if ($request->has('age_groups') && !empty($request->age_groups)) {
            $age_groups = $request->age_groups;
            $query->whereHas('ageGroups', function ($q) use ($age_groups) {
                $q->whereIn('age_group_id', $age_groups);
            });
        }

        if ($request->has('specialties') && !empty($request->specialties)) {
            $specialties = $request->specialties;
            $query->whereHas('specialties', function ($q) use ($specialties) {
                $q->whereIn('specialty_id', $specialties);
            });
        }

        if ($request->has('working_styles') && !empty($request->workingStyles)) {
            $workingStyles = $request->workingStyles;
            $query->whereHas('workingStyles', function ($q) use ($workingStyles) {
                $q->whereIn('style_id', $workingStyles);
            });
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $query->whereHas('doctorProfile', function ($q) use ($minPrice, $maxPrice) {
                $q->where('price', '>=', $minPrice)->orWhere('price', '<=', $maxPrice);
            });
        }

        if ($request->filled('preferred_time_from') && $request->filled('preferred_time_to')) {
            
            $from = $request->input('preferred_time_from');
            $to = $request->input('preferred_time_to');
            $query->whereHas('slots', function ($q) use ($from, $to) {
                $q->where('time_from', '>=', $from)->orWhere('time_from', '<=', $to);
            });
        }

        if ($request->has('session_duration') && !empty($request->session_duration)) {
            $doctorSessions = $request->session_duration;
            $query->whereHas('doctorSessions', function ($q) use ($doctorSessions) {
                $q->whereIn('session_id', $doctorSessions);
            });
        }

        if ($request->has('preferred_day') && !empty($request->preferred_day)) {
            $query->whereHas('slots', function ($q) use ($request) {
                $q->whereIn('day', $request->preferred_day);
            });
        }



        $doctors = $query->skip($offset)->take($limit)->get();

        return [
            'total_size' => $doctors->count(),
            'limit' => $limit,
            'offset' => $page,
            'doctors' => DashboardDoctorResource::collection($doctors),
        ];
    }





    public function categories()
    {
        $categories = Category::childrensOnly()->select('id', 'name')->get();

        return FiltersCategoryResource::collection($categories);
    }

    public function ageGroups()
    {
        return ['data' => AgeGroup::get(['id', 'range'])];
    }
    public function sessionRanges()
    {
        return ['data' => SessionRange::get(['id', 'name', 'range'])];
    }
    public function priceRanges()
    {
        return ['data' => PriceRange::get(['id', 'name', 'range'])];
    }

    public function yoeRanges()
    {
        return ['data' => YOERange::get(['id', 'name', 'range'])];
    }

    public function timeSlots()
    {
        return ['data' => Slot::get(['id', 'time'])];
    }

    public function languages()
    {
        return ['data' => SpeakingLanguage::get(['id', 'lang'])];
    }

    public function qualifications()
    {
        return ['data' => Qualification::get(['id', 'name'])];
    }

    public function specialties(Request $request)
    {
        $specialties =  Specialty::when($request->name, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%');
        })->get(['id', 'name']);
        return ['data' => $specialties];
    }

    public function workingStyles(Request $request)
    {
        $workingStyles =  WorkingStyle::when($request->name, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%');
        })->get(['id', 'name']);
        return ['data' => $workingStyles];
    }

    public function sessionsDurations()
    {
        return ['data' => Session::get(['id', 'name'])];
    }
}
