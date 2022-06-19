<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'phone'=>'required|string|unique:users,phone',
            'document_number'=>'required|string|digits:10',
            'password'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
               'error'=>(object)[
                   'code'=>422,
                   'message'=>'Validation error',
                   'errors'=>$validator->errors()
               ]
            ],422);
        }
        $user = new UsersModel();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone = $request->input('phone');
        $user->document_number = $request->input('document_number');
        $user->password = $request->input('password');
        $user->save();
        return response()->json()->setStatusCode(204);
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'phone'=>'required',
            'password'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=>(object)[
                    'code'=>422,
                    'message'=>'Validation error',
                    'errors'=>$validator->errors()
                ]
            ],422);
        }
        $phone = $request->input('phone');
        $password = $request->input('password');
        if($user = UsersModel::where('phone',$phone)->first()){
            if($password === $user->password){
                $token = Str::random(50);
                $user->api_token = $token;
                $user->save();
                return response()->json([
                    'data'=>(object)[
                        'token'=>$token
                    ]
                ],200);
            }
        }
        return response()->json([
            'error'=>(object)[
                'code'=>401,
                'message'=>'Unauthorized',
                'errors'=>(object)[
                    'phone'=>'phone or password incorrect'
                ]
            ]
        ],401);
    }
}
