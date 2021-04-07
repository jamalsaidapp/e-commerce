<?php


namespace App\Services\ServiceImpl;


use App\Models\Categorie;
use App\Services\CategoriesServices;

class CategoriesServicesImpl implements CategoriesServices
{
    public function GetCategories()
    {
        return Categorie::latest('id')->get();
    }

    public function CreateCategory($data)
    {
        Categorie::create($data);
    }
    public function UpdateCategory($data , $categorie)
    {
        $categorie->update($data);
    }
    public function DeleteCategory($categorie)
    {
        $categorie->delete();
    }
}
