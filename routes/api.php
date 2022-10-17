<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;


Route::post('login', [ApiAuthController::class, 'login']);







// Route::controller(RegisterController::class)->group(function(){
//     Route::post('register', 'register');
//     Route::post('login', 'login');
// });




Route::middleware('auth:sanctum')->group( function () {

    Route::get('get-user', [UserController::class, 'get_user']);


   Route::resource('profile', UserController::class);
});
