<?php


namespace App\Services\ServiceImpl;


use App\Models\User;

class UserServiceImpl implements \App\Services\UserService
{
    public function GetUsers()
    {
        return User::latest('id')->get();
    }

    public function CreateUser($data)
    {
        $newData = data_set($data, 'password', \Hash::make($data['password']));
        $id = User::insertGetId($newData);
        $this->CreateUserFolder($id . '/Profile');
    }

    public function UpdateUser($data, $id)
    {
        $user = User::findOrFail($id);

        if (isset($data['password'])) {
            $newData = data_set($data, 'password', \Hash::make($data['password']));
            return $user->update($newData);
        }
        return $user->update($data);
    }

    public function DeleteUser( $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $this->DeleteUserFolder($id);
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


}
