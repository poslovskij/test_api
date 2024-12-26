<?php
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

	Route::apiResource('projects', ProjectController::class);

	Route::post('projects/{project}/tasks', [TaskController::class, 'store']);
	Route::get('projects/{project}/tasks', [TaskController::class, 'index']);
	Route::put('tasks/{task}', [TaskController::class, 'update']);
	Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
});
