<?php

use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('districts', DistrictController::class)->only([
    'index', 'store', 'destroy'
]);

Route::get('/get-district', [DistrictController::class, 'getDistrictBasedOnStudentId']);

Route::resource('schools', SchoolController::class)->only([
    'store'
]);

Route::resource('students', StudentController::class)->only([
    'index', 'store'
]);