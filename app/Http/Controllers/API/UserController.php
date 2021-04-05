<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->GetUsers();
    }

    public function store(UserCreateRequest $request)
    {
        return $this->userService->CreateUser($request->validated());
    }

    public function update(UserUpdateRequest $request, $id)
    {
        return $this->userService->UpdateUser($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->userService->DeleteUser($id);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $path = public_path('Users/' . $user->id . '/Profile/');


        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6'
        ]);

        $currentPhoto = $user->photo;

        if ($request->photo != $currentPhoto) {
            $name = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            Image::make($request->photo)->save($path . $name);
            $request->merge(['photo' => $name]);

            $userPhoto = $path . $currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message' => "Success"];
    }


    public function profile()
    {
        return auth('api')->user();

    }

    public function MultiUserDelete(Request $request)
    {
        $ids = $request->ids;
        return User::destroy($ids);
    }

    public static function CreateUserFolder($id): bool
    {
        $path = public_path('/Users/' . $id);

        if (!\File::exists($path)) {
            return \File::makeDirectory($path, 0777, true, true);
        } else {
            return false;
        }
    }

    public static function DeleteUserFolder($id): bool
    {
        $path = public_path('/Users/' . $id);

        if (\File::exists($path)) {
            return \File::deleteDirectory($path);
        } else {
            return false;
        }
    }
}
