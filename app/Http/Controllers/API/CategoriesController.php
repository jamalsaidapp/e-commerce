<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryCreateRequest;
use App\Http\Requests\Categories\CategoryUpadteRequest;
use App\Models\Categorie;
use App\Services\CategoriesServices;

class CategoriesController extends Controller
{
    protected $categorieService;

    public function __construct(CategoriesServices $categorieService)
    {
        $this->categorieService = $categorieService;
    }

    public function index()
    {
        return $this->categorieService->GetCategories();
    }

    public function store(CategoryCreateRequest $request)
    {
        $this->categorieService->CreateCategory($request->validated());
    }

    public function update(CategoryUpadteRequest $request, Categorie $categorie)
    {
        $this->categorieService->UpdateCategory($request->validated(), $categorie);
    }

    public function destroy(Categorie $categorie)
    {
        $this->categorieService->DeleteCategory($categorie);
    }
}
