<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Status;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function(){

    Route::post('login',[LoginController::class,'authenticate']);
    Route::post('register',[RegisterController::class,'register']);
    Route::post('logout',[LoginController::class,'logout'])->middleware(['JwtAuth']); 
    Route::post('me',[LoginController::class,'verifyAuth'])->middleware(['JwtAuth']);

});

Route::get('users',[UserController::class,'index'])->middleware(['JwtAuth']);

Route::middleware(['JwtAuth'])->prefix('pm')->group(function() {

    Route::prefix('projects')->group(function() {
        Route::get('index/{id?}',[ProjectController::class,'index']);
        Route::post('store',[ProjectController::class,'store']);
        Route::put('update/{project}',[ProjectController::class,'update']);
        Route::delete('destroy/{project}',[ProjectController::class,'destroy']);
    });

    Route::prefix('tasks')->group(function() {
        Route::get('index/{id?}',[TaskController::class,'index']);
        Route::get('for-user',[TaskController::class,'tasksUser']);
        Route::post('store',[TaskController::class,'store']);
        Route::post('store/project-tasks',[TaskController::class,'storeProjectTasks']);
        Route::put('update/{project}',[TaskController::class,'update']);
        Route::delete('destroy/{project}',[TaskController::class,'destroy']);
    });

    Route::prefix('statuses')->group(function() {
        Route::get('index/',[StatusController::class,'index']);
        Route::get('show/{id}',[StatusController::class,'show']);
        Route::get('tasks-user',[StatusController::class,'taskForUser']);
        Route::post('store',[StatusController::class,'store']);
        Route::put('update/{project}',[StatusController::class,'update']);
        Route::delete('destroy/{project}',[StatusController::class,'destroy']);
    });

});
