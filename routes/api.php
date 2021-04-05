<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//User Routes
Route::apiResource('user',App\Http\Controllers\API\UserController::class);
Route::get('profile', function (){return auth('api')->user();});
Route::put('profile', [App\Http\Controllers\API\UserController::class, 'updateProfile']);
Route::get('MultiUserDelete', [App\Http\Controllers\API\UserController::class, 'MultiUserDelete']);


//Categorie Routes
Route::apiResource('categorie',App\Http\Controllers\API\CategoriesController::class);


