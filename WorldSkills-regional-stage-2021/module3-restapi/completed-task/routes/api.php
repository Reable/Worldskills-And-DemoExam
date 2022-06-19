<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\SeatController;

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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::get('/airport',[FlightController::class,'airport']);
Route::get('/flight',[FlightController::class,'flight']);

Route::post('/booking',[BookingController::class,'booking']);
Route::get('/booking/{code}',[BookingController::class,'booking_info']);

Route::get('booking/{code}/seat',[SeatController::class,'seat']);
Route::patch('booking/{code}/seat',[SeatController::class,'seat_update']);
