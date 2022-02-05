<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'EmailVerification'])->group(function () {
    
    Route::post('send_invite', [App\Http\Controllers\EmailController::class, 'SendInvite'])->middleware(['InviteSignup']);


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/invite', function(){
        return view('admin.invite');
    })->middleware(['InviteSignup']); 

    Route::get('/email_verification', function(){
        return view('user.email_verification');
    });

    Route::post('/email_verification', [App\Http\Controllers\EmailController::class, 'email_verification'])->middleware(['auth']); 
});



