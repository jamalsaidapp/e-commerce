<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(auth()->check())
    {
        return redirect('/back_index');
    }
    else{
        return view('frontend.index');
    }
});


//Auth::routes();

Route::get('/login', function () {return view('backend.index');});
Route::get('/admin', function () {return view('backend.index');});
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('{path}', [App\Http\Controllers\HomeController::class, 'index'])->where( 'path', '([A-z\/_.\d-]+)?' );


