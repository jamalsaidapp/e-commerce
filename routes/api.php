<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//User Routes
Route::apiResource('user',App\Http\Controllers\API\UserController::class);
Route::get('profile', [App\Http\Controllers\API\UserController::class, 'profile']);
Route::get('MultiUserDelete', [App\Http\Controllers\API\UserController::class, 'MultiUserDelete']);


