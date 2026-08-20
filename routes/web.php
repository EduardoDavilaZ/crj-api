<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MemeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CraftController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => '¡Docker, Laravel y la API están funcionando perfectamente!'
    ]);
});

Route::post('/register-shift', [RegistrationController::class, 'store']);

Route::post('/feedback', [FeedbackController::class, 'store']);
Route::get('/feedback/{code}', [FeedbackController::class, 'show']);


Route::get('/get-projects-with-shifts', [ProjectController::class, 'getProjectsWithShifts']);
Route::get('/get-locations', [LocationController::class, 'getLocations']);


Route::get('/location', [LocationController::class, 'getLocations']);
Route::get('/location/{id}', [LocationController::class, 'getLocationsById']);
Route::get('/project/{id}/location', [LocationController::class, 'getLocationsByProject']);

Route::get('/project/{id}/shifts', [ProjectController::class, 'getShiftsByProject']);

Route::get('/memes', [MemeController::class, 'index']);


Route::get('/age-ranges', [ActivityController::class, 'getAgeRanges']);
Route::get('/activity-types', [ActivityController::class, 'getActivityTypes']);
Route::get('/activity', [ActivityController::class, 'getActivity']);

Route::get('/crafts/age-ranges', [CraftController::class, 'getAgeRanges']);
Route::get('/craft', [CraftController::class, 'getCraft']);
