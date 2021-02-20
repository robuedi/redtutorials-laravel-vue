<?php

use App\Http\Controllers\admin\AuthenticationController;
use App\Http\Controllers\admin\DashboardController;
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


// Admin
Route::group(['namespace' => 'admin', 'prefix' => config('app.admin_route')], function(){

    //Authentication
    Route::get('/', [AuthenticationController::class, 'login']);
    Route::post('/login', [AuthenticationController::class, 'doLogin']);
    Route::get('/logout', [AuthenticationController::class, 'logout']);

    //Require authentication
    Route::group(['middleware' => 'admin_section'], function()
    {
        //Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});
