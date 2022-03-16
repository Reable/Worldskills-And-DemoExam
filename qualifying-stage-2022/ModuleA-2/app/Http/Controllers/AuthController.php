<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register_page(){

    }
    public function register_post(Request $request){
        $validator = Validator::make($request->all(),[
            'login'=>'required|unique:users,login|min:3|max:20',
            'name'=>'required|min:2|max:50',
            'password'=>'required|min:3|max:120',
            'image'=>'required|mimes:png,jpg,svg|image'
        ]);
        if($validator->fails()){
            return response()->json([
               'error'=>(object)[
                   'message'=>'Validation errors',
                   'errors'=>$validator->errors()
               ]
            ],422);
        }

        $path = $request->file('image')->store('images/user');

        $user = new UserModel();
        $user->login = $request->input('login');
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->image = $path;

        $user->save();

        return response()->json([
           'data'=>(object)[
               'redirect'=>'/login',
               'message'=>'Вы успешно зарегестрировались'
           ]
        ],200);
    }
    public function login_get(){

    }
    public function login_post(Request $request){
        $validator = Validator::make($request->all(),[
            'login'=>'required',
            'password'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=>(object)[
                    'message'=>'Validation errors',
                    'errors'=>$validator->errors()
                ]
            ],422);
        }

        $login = $request->input('login');
        $password = $request->input('password');

        if($user = UserModel::where('login',$login)->first()){
            if(Hash::check($password,$user->password)){
                $user->remember_token = Str::random(120);
                return response()->json([
                    'data'=>(object)[
                        'message'=>'Вы успешно авторизировались',
                        'user'=>$user
                    ]
                ],200);
            }
        }
        return response()->json([
            'error'=>(object)[
                'message'=>'Ошибка авторизации',
                'errors'=>[
                    'login'=>'Ошибка логина или пароля'
                ]
            ]
        ],401);

    }
}
