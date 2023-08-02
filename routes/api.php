<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskContoller;

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
Route::controller(UserController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
    
});
Route::middleware('auth:sanctum')->group(function(){
    Route::get("get/task",[TaskContoller::class,'showTasks']);
    Route::get("get/user",[UserController::class,'getUser']);
    Route::post("add/task",[TaskContoller::class,'addTasks']);
    Route::put("update/task",[TaskContoller::class,'UpdateTasks']);
    Route::delete("delete/task",[TaskContoller::class,'DeleteTasks']);
    
});

