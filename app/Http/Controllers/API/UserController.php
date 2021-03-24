<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

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
            'role' => 'required',
            'status' => 'required'
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

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $path = public_path('Users/'.$user->id.'/Profile/');


        $this->validate($request,[
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:6'
        ]);

        $currentPhoto = $user->photo;

        if($request->photo != $currentPhoto ){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            Image::make($request->photo)->save($path.$name);
            $request->merge(['photo' => $name]);

            $userPhoto = $path.$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message' => "Success"];
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
//        $this->DeleteUserFolder($id);
        return ['message' => 'User and Folder Deleted'];
    }

    public function MultiUserDelete(Request $request)
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
