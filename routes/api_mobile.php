<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Mobile\{
    FilterController,
    TimeZoneController,
    RatingController,
    PatientController,
    OptimizeController,
    auth\AuthController,
    DashboardController,
    DoctorController
};

Route::prefix('cache')->group(function () {
    Route::get('optimize', [OptimizeController::class, 'optimize'])->name('cache.optimize');
    Route::get('clear', [OptimizeController::class, 'clear'])->name('cache.clear');
    Route::get('status', [OptimizeController::class, 'status'])->name('cache.status');
});

/****************************** Mobile App Routes ************************************/
// Mobile AUTH
Route::prefix('auth')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('verify', [AuthController::class, 'verify']);

    Route::post('generate-otp', [AuthController::class, 'generateOTP']);
    Route::post('validate-otp', [AuthController::class, 'validateOTP']);

    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('new-password', [AuthController::class, 'newPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('delete', [AuthController::class, 'deleteAccount']);
    });
});
/**************************************************************************************/

// Mobile
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/menu', [DashboardController::class, 'menu']);
        Route::get('/home', [DashboardController::class, 'home']);
        Route::get('/search', [DashboardController::class, 'search']);
        Route::get('/doctor/{id}', [DashboardController::class, 'doctorById']);
        Route::get('/doctors-by-category', [DashboardController::class, 'doctorsByCategory']);
        Route::post('/slots', [DashboardController::class, 'slots']);
        Route::get('/doctor-groups/{id?}', [DashboardController::class, 'doctorGroups']);
    });

    // Filters
    Route::prefix('filters')->group(function () {
        Route::get('/categories', [FilterController::class, 'categories']);
        Route::get('/age-groups', [FilterController::class, 'ageGroups']);
        Route::get('/session-ranges', [FilterController::class, 'sessionRanges']);
        Route::get('/price-ranges', [FilterController::class, 'priceRanges']);
        Route::get('/yoe-ranges-ranges', [FilterController::class, 'priceRanges']);
        Route::get('/yoe-ranges', [FilterController::class, 'yoeRanges']);
        Route::get('/time-slots', [FilterController::class, 'timeSlots']);
        Route::get('/languages', [FilterController::class, 'languages']);
        Route::get('/qualifications', [FilterController::class, 'qualifications']);
        Route::get('/specialties', [FilterController::class, 'specialties']);
        Route::get('/working-styles', [FilterController::class, 'workingStyles']);
        Route::post('/find-expert', [FilterController::class, 'findExpert']);
        Route::post('/find-expert2', [FilterController::class, 'findExpert2']);
        Route::get('/sessions-durations', [FilterController::class, 'sessionsDurations']);
    });

    Route::prefix('rating')->group(function () {
        Route::post('/group/{group_id}', [RatingController::class, 'rateDoctorGroup']);
        Route::post('/booking/{booking_id}', [RatingController::class, 'rateDoctorBooking']);
    });

    // Patient
    Route::prefix('patient')->group(function () {
        Route::get('/profile', [PatientController::class, 'getProfile']);
        Route::post('/update-profile', [PatientController::class, 'updateProfile']);
        Route::post('/update-password', [PatientController::class, 'updatePassword']);
        Route::post('/update-avatar', [PatientController::class, 'updateAvatar']);

        //groups
        Route::post('/join-group', [PatientController::class, 'joinGroup']);
        Route::get('/joined-groups', [PatientController::class, 'joinedGroups']);

        //slots
        Route::post('/book-slot', [PatientController::class, 'bookSlot']);
        Route::get('/booked-slots', [PatientController::class, 'bookedSlots']);
    });


    // Doctor
    Route::prefix('doctor')->group(function () {
        Route::get('/home', [DoctorController::class, 'home']);
        Route::get('/profile', [DoctorController::class, 'getProfile']);
        Route::post('/update-profile', [DoctorController::class, 'updateProfile']);
        Route::post('/update-password', [DoctorController::class, 'updatePassword']);

        Route::prefix('groups')->group(function () {
            Route::get('/', [DoctorController::class, 'groups']);
            Route::post('/create', [DoctorController::class, 'creategroup']);
            Route::post('/update', [DoctorController::class, 'updategroup']);
            Route::post('/delete', [DoctorController::class, 'deletegroup']);
        });

        Route::prefix('slots')->group(function () {
            Route::post('/', [DoctorController::class, 'slots']);
            Route::post('/update', [DoctorController::class, 'updateSlots']);
        });


    });

    Route::get('/time-zones', TimeZoneController::class);


});
