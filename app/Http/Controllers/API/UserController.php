<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => []]);
    }

    public function index()
    {
        return User::latest('id')->get();
    }
    public function profile()
    {
        return  auth('api')->user();

    }

    public function store(Request $request){

        $this->validate($request,[
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6',

        ]);

        $id =  User::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'role' => $request->role,
            'password' => Hash::make($request['password']),
        ]);
//        $id =  User::insertGetId($request->all());

//        $this->CreateUserFolder($id.'/Profile');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:6',
            'Role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'role' => $request->role,
        ]);

        if($request->has('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
//        $this->DeleteUserFolder($id);
        return ['message' => 'User and Folder Deleted'];
    }
    public function multiDelete(Request $request)
    {
        $ids = $request->ids;
        return  User::destroy($ids);
    }

    public static function CreateUserFolder($id): bool
    {
        $path = public_path('/Users/' .$id);

        if (! \File::exists($path))
        {
            return \File::makeDirectory($path, 0777, true, true);
        }
        else{
            return false;
        }
    }
    public static function DeleteUserFolder($id): bool
    {
        $path = public_path('/Users/' .$id);

        if ( \File::exists($path))
        {
            return \File::deleteDirectory($path);
        }
        else{
            return false ;
        }
    }
}
