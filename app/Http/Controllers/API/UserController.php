<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => []]);
    }

    public function index()
    {
        return User::latest('id')->get();
    }
    public function profile()
    {
        return  auth('api')->user();

    }
}
