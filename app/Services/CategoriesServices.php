<?php

namespace App\Services;

interface CategoriesServices
{
    public function GetCategories();

    public function CreateCategory($data);

    public function UpdateCategory($data, $categorie);

    public function DeleteCategory($categorie);
}
