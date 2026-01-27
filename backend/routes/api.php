<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth Routes
Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');;
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
    Route::put('/user', [AuthController::class, 'update'])->middleware('auth:sanctum');


});

// Github Login
Route::group(['middleware' => ['web']], function () {
    Route::get('/login/github', [AuthController::class, 'github']);
    Route::get('/login/github/redirect', [AuthController::class, 'githubRedirect'])->middleware('web');;
});

// Project Routes
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/user_projects', [ProjectController::class, 'getUserProjects'])->middleware('auth:sanctum');
Route::post('/projects/create', [ProjectController::class, 'create'])->middleware('auth:sanctum');
Route::post('/projects/{project}', [ProjectController::class, 'update'])->middleware('auth:sanctum', 'is_admin');

// Enrollment Routes
Route::post('/enrollment', [EnrollmentController::class, 'store'])->middleware(['auth:sanctum', 'is_admin']);;
Route::get('/enrollments', [EnrollmentController::class, 'index']);

