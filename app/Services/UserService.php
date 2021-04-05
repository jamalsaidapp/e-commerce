<?php

namespace App\Services;

interface UserService
{
//    User CRUD
    public function GetUsers();

    public function CreateUser($data);

    public function UpdateUser($data, $user);

    public function DeleteUser($user);

//    Profile Fuction
    public function UpdateUserImage($image);
}
