<?php


namespace App\Services\ServiceImpl;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserServiceImpl implements \App\Services\UserService
{
//    User CRUD
    public function GetUsers()
    {
        return User::latest('id')->get();
    }

    public function CreateUser($data)
    {
        $newData = data_set($data, 'password', Hash::make($data['password']));
        $id = User::insertGetId($newData);
        $this->CreateUserFolder($id . '/Profile');
    }

    public function UpdateUser($data, $user)
    {
        if (isset($data['password'])) {
            $newData = data_set($data, 'password', Hash::make($data['password']));
            return $user->update($newData);
        }
        return $user->update($data);
    }

    public function DeleteUser($user): array
    {
        $user->delete();
        $this->DeleteUserFolder($user->id);
        return ['message' => 'User and Folder Deleted'];
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

//    Profile Function
    public function UpdateUserImage($image)
    {
        $user = auth('api')->user();
        $path = public_path('Users/' . $user->id . '/Profile/');
        $currentPhoto = $user->photo;

        if (isset($image)) {
            if ($image != $currentPhoto) {
                $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

                Image::make($image)->save($path . $name);
                $user->update(['photo' => $name]);
                $userPhoto = $path . $currentPhoto;
                if (file_exists($userPhoto)) {
                    @unlink($userPhoto);
                }
            }
        }
    }
}
