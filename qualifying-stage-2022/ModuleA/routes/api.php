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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('/register','register')->name('register');
    Route::post('/login','login')->name('login');
});
Route::controller(NewsController::class)->group(function(){
    Route::get('/all-news','all_news')->name('all_news');
    Route::post('/add-news','add_news')->name('add_news');
    Route::get('/my-news/{user_id}','my_news')->name('my_news');
});

