<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(LoginController::class)->group(function(){
    Route::get('/user','index')->name('login.index');
    Route::post('/login','store')->name('login.store');
});

Route::middleware('auth:sanctum')->group(function(){
    //____________VendorController___________
    Route::controller(VendorController::class)->group(function(){
        Route::get('/vendor','index')->name('vendor.index');
        Route::post('/vendor','store')->name('vendor.store');
        Route::delete('/vendor/delete/{id}','destroy')->name('vendor.destroy');
        Route::put('/vendor/{id}','update')->name('vendor.update');


    });
});

