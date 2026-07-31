<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => '¡Docker, Laravel y la API están funcionando perfectamente!'
    ]);
});

Route::post('/registrations', [RegistrationController::class, 'store']);

Route::post('/feedbacks', [FeedbackController::class, 'store']);
Route::get('/feedbacks/{code}', [FeedbackController::class, 'show']);


Route::get('/get-projects-with-shifts', [ProjectController::class, 'getProjectsWithShifts']);
Route::get('/get-locations', [LocationController::class, 'getLocations']);


Route::get('/location', [LocationController::class, 'getLocations']);
Route::get('/location/{id}', [LocationController::class, 'getLocationsById']);
Route::get('/project/{id}/location', [LocationController::class, 'getLocationsByProject']);
