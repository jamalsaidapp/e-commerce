<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => []]);
    }

    public function index()
    {
        return Categorie::latest('id')->get();
    }

    public function store(Request $request){

        $this->validate($request,[
            'title' => 'required|string|max:50',
            'slug' => 'required|string|unique:categories',
            'status' => 'required|string',

        ]);

         Categorie::create($request->all());

    }

    public function update(Request $request, $id)
    {
        $cate = Categorie::findOrFail($id);

        $this->validate($request,[
            'title' => 'required|string',
            'slug' => 'required|string|unique:categories,slug,'.$cate->id,
            'status' => 'required|string',
        ]);

        $cate->update($request->all());
    }

    public function destroy($id)
    {
        $user = Categorie::findOrFail($id);
        $user->delete();
    }
}
