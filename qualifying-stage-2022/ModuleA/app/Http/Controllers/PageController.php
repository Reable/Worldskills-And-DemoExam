<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function index(Request $request){
        return view('index');
    }
    public function login_page(Request $request){
        return view('login');
    }
    public function register_page(Request $request){
        return view('register');
    }
    public function personal_area(Request $request){
        return view('personal-area');
    }

}
