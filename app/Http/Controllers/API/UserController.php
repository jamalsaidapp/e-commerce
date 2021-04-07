<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateProfileRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{

    protected  $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->GetUsers();
    }

    public function store(UserCreateRequest $request)
    {
         $this->userService->CreateUser($request->validated());
    }

    public function update(UserUpdateRequest $request, User $user)
    {
         $this->userService->UpdateUser($request->validated(), $user);
    }

    public function destroy(User $user)
    {
         $this->userService->DeleteUser($user);
    }

    public function MultiUserDelete(Request $request)
    {
         User::destroy($request->ids);
    }

    public function updateProfile(UserUpdateProfileRequest $request)
    {
         $this->userService->UpdateUser($request->validated(), auth()->user());
    }

    public function updateUserImage(Request $request)
    {
         $this->userService->UpdateUserImage($request->img);
    }

}
