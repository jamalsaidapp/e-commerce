<?php

namespace App\Services;

interface UserService
{
    public function GetUsers();

    public function CreateUser($data);

    public function UpdateUser($data,$id);

    public function DeleteUser($id);
}
