<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
           'login'=>'required|min:3|max:20|unique:users,login',
           'name'=>'required|min:2|max:100',
           'password'=>'required:min:4',
           'image'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=>(object)[
                    'message'=>'Ошибка валидации',
                    'status'=>422,
                    'errors'=>$validator->errors(),
                ]
            ],422);
        }

        $user = new UsersModel();
        $path = $request->file('image')->store('images');

        $user->login = $request->input('login');
        $user->name = $request->input('name');
        $user->image = $path;
        $user->password = bcrypt($request->input('password'));

        $user->save();

        return response()->json([
            'data'=>(object)[
                'message'=>'Вы успешно зарегестрировались',
                'status'=>201
            ]
        ],201);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'login'=>'required',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=>(object)[
                    'message'=>'Validation error',
                    'status'=>422,
                    'errors'=>$validator->errors()
                ]
            ],422);
        }

        $login = $request->input('login');
        $password = $request->input('password');

        if($user = UsersModeL::where('login',$login)->first()){
            if(Hash::check($password,$user->password)){
                $user->remember_token = Str::random(50);
                $user->save();
                return response()->json([
                    'data'=>(object)[
                        'message'=>'Вы авторизировались',
                        'status'=>200,
                        'user'=>$user,
                    ]
                ],200);
            }
        }
        return response()->json([
            'error'=>(object)[
                'message'=>'Ошибка авторизации',
                'status'=>401,
                'errors'=>[
                    'login'=>'ошибка логина или пароля'
                ]
            ]
        ],401);

    }
}
