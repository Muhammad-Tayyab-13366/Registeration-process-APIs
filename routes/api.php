<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
// test_brach check commit
Route::middleware('auth:sanctum')->group(function () {
    //All secure URL's
    Route::post("/UpdateProfile",[UserController::class,'UpdateProfile']);

});

Route::post("/getAccessToken",[UserController::class,'index']);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');