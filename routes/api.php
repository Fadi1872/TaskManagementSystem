<?php

use App\Http\Controllers\Api\PrioritiesController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UsersContorller;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/status', StatusController::class);
    Route::apiResource('/priority', PrioritiesController::class);
    Route::apiResource('/task', TaskController::class);
    Route::put('/task/status/{task}', [TaskController::class, 'updateStatus']);
    Route::apiResource('/user', UsersContorller::class)->except(['show']);
    Route::post('/user/activation/{user}', [UsersContorller::class, 'toggleActivation']);
});