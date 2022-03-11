<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(PageController::class)->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/login','login_page')->name('login_page');
    Route::get('/register','register_page')->name('register_page');
    Route::get('/personal-area','personal_area')->name('personal_area');
});



