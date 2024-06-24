<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Api\Mobile\TimeZoneController;
use App\Http\Controllers\Api\Admin\{
    AuthController,
    AdminController,
    DoctorsController,
    DoctorGroupsController,
    PatientsController,
    DashboardController,
    AgeGroupsController,
    CategoriesController,
    SpecialtiesController,
    WorkingStylesController,
    QualificationsController,
    SessionsController,
    SpeakingLanguagesController
};



/******************************** Admin API Routes ***********************************/

// AUTH
Route::post('login',  [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

// Dashboard
Route::middleware('auth:sanctum')->group(function () {

    // Permissions
    Route::get('permissions', [PermissionController::class, 'index']);

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);

    // Admins
    Route::prefix('admins')->group(function () {
        Route::get('/list',         [AdminController::class, 'list']);
        Route::post('/add',         [AdminController::class, 'create']);
        Route::get('/edit/{id}',    [AdminController::class, 'edit']);
        Route::post('/update/{id}', [AdminController::class, 'update']);
        Route::post('/delete/{id}', [AdminController::class, 'delete']);
    });

    // Doctors
    Route::prefix('doctors')->group(function () {
        Route::get('/list',         [DoctorsController::class, 'list']);
        Route::post('/add',         [DoctorsController::class, 'create']);
        Route::get('/edit/{id}',    [DoctorsController::class, 'edit']);
        Route::post('/update/{id}', [DoctorsController::class, 'update']);
        Route::post('/delete/{id}', [DoctorsController::class, 'delete']);
        Route::get('/edit-slot/{id}',    [DoctorsController::class, 'editSlot']);
        Route::post('/update-slot/{id}',    [DoctorsController::class, 'updateSlot']);
        Route::post('/delete-media/{id}', [DoctorsController::class, 'deleteMedia']);
        Route::get('/extra', [DoctorsController::class, 'extra']);
    });
    // DoctorGroups
    Route::prefix('doctor/groups')->group(function () {
        Route::get('/list/{id?}',         [DoctorGroupsController::class, 'list']);
        Route::post('/add/{id}',         [DoctorGroupsController::class, 'create']);
        Route::get('/edit/{id}',    [DoctorGroupsController::class, 'edit']);
        Route::post('/update/{id}', [DoctorGroupsController::class, 'update']);
        Route::post('/delete/{user_id}/{id}', [DoctorGroupsController::class, 'delete']);
    });

    // Patients
    Route::prefix('patients')->group(function () {
        Route::get('/list',         [PatientsController::class, 'list']);
        Route::post('/add',         [PatientsController::class, 'create']);
        Route::get('/edit/{id}',    [PatientsController::class, 'edit']);
        Route::post('/update/{id}', [PatientsController::class, 'update']);
        Route::post('/delete/{id}', [PatientsController::class, 'delete']);
        Route::post('/delete-media/{id}', [PatientsController::class, 'deleteMedia']);
    });

    // Qualifications
    Route::prefix('qualifications')->group(function () {
        Route::get('/all',          [QualificationsController::class, 'all']);
        Route::get('/list',         [QualificationsController::class, 'list']);
        Route::post('/add',         [QualificationsController::class, 'create']);
        Route::get('/edit/{id}',    [QualificationsController::class, 'edit']);
        Route::post('/update/{id}', [QualificationsController::class, 'update']);
        Route::post('/delete/{id}', [QualificationsController::class, 'delete']);
    });

    // Specialties
    Route::prefix('specialties')->group(function () {
        Route::get('/all',          [SpecialtiesController::class, 'all']);
        Route::get('/list',         [SpecialtiesController::class, 'list']);
        Route::post('/add',         [SpecialtiesController::class, 'create']);
        Route::get('/edit/{id}',    [SpecialtiesController::class, 'edit']);
        Route::post('/update/{id}', [SpecialtiesController::class, 'update']);
        Route::post('/delete/{id}', [SpecialtiesController::class, 'delete']);
    });

    // AgeGroups
    Route::prefix('age_groups')->group(function () {
        Route::get('/all',          [AgeGroupsController::class, 'all']);
        Route::get('/list',         [AgeGroupsController::class, 'list']);
        Route::post('/add',         [AgeGroupsController::class, 'create']);
        Route::get('/edit/{id}',    [AgeGroupsController::class, 'edit']);
        Route::post('/update/{id}', [AgeGroupsController::class, 'update']);
        Route::post('/delete/{id}', [AgeGroupsController::class, 'delete']);
    });

    // WorkingStyles
    Route::prefix('working_styles')->group(function () {
        Route::get('/all',          [WorkingStylesController::class, 'all']);
        Route::get('/list',         [WorkingStylesController::class, 'list']);
        Route::post('/add',         [WorkingStylesController::class, 'create']);
        Route::get('/edit/{id}',    [WorkingStylesController::class, 'edit']);
        Route::post('/update/{id}', [WorkingStylesController::class, 'update']);
        Route::post('/delete/{id}', [WorkingStylesController::class, 'delete']);
    });

    // SpeakingLanguages
    Route::prefix('speaking_languages')->group(function () {
        Route::get('/all',          [SpeakingLanguagesController::class, 'all']);
        Route::get('/list',         [SpeakingLanguagesController::class, 'list']);
        Route::post('/add',         [SpeakingLanguagesController::class, 'create']);
        Route::get('/edit/{id}',    [SpeakingLanguagesController::class, 'edit']);
        Route::post('/update/{id}', [SpeakingLanguagesController::class, 'update']);
        Route::post('/delete/{id}', [SpeakingLanguagesController::class, 'delete']);
    });

    // Sessions
    Route::prefix('sessions')->group(function () {
        Route::get('/all',          [SessionsController::class, 'all']);
        Route::get('/list',         [SessionsController::class, 'list']);
        Route::post('/add',         [SessionsController::class, 'create']);
        Route::get('/edit/{id}',    [SessionsController::class, 'edit']);
        Route::post('/update/{id}', [SessionsController::class, 'update']);
        Route::post('/delete/{id}', [SessionsController::class, 'delete']);
    });



    // Categories
    Route::prefix('categories')->group(function () {
        Route::get('/list',         [CategoriesController::class, 'list']);
        Route::post('/add',         [CategoriesController::class, 'create']);
        Route::get('/edit/{id}',    [CategoriesController::class, 'edit']);
        Route::post('/update/{id}', [CategoriesController::class, 'update']);
        Route::post('/delete/{id}', [CategoriesController::class, 'delete']);
        Route::get('/extra',        [CategoriesController::class, 'extra']);
        Route::post('/delete-media/{id}', [CategoriesController::class, 'deleteMedia']);
    });

    Route::get('/time-zones', TimeZoneController::class);
});
/****************************** Admin API Routes *********************************/
