<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function(){
    Route::post('/register','register_post');
    Route::post('/login','login_post');
});

Route::controller(NewsController::class)->group(function(){
    Route::get('/all-news','all_news');
    Route::get('/my-news/{id}','my_news');
    Route::get('/subscribe','subscribe');
    Route::post('/add-news','add_news_post');
});
