<?php

use App\Http\Controllers\admin\AuthenticationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TutorialsController;
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


// Admin/CMS side
Route::group(['namespace' => 'admin', 'prefix' => config('app.admin_route')], function(){

    //Authentication
    Route::get('/', [AuthenticationController::class, 'login']);
    Route::post('/login', [AuthenticationController::class, 'doLogin']);
    Route::get('/logout', [AuthenticationController::class, 'logout']);

    //Require authentication
    Route::group(['middleware' => 'admin_auth'], function()
    {
        //Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});

// Client side

//Home
Route::get('/', [HomeController::class, 'index']);

//Tutorials (SEO optimized URLs)
Route::get('/{course_slag}', [TutorialsController::class, 'showCourseContent'])->where('course_slag', '^([^\s\/]+)-tutorial$');
Route::get('/{course_slag}/{chapter_slag}/{lesson_slag}', [TutorialsController::class, 'showLessonContent'])->where('course_slag', '^([^\s\/]+)-tutorial$');

//Glide - for images
Route::get('/images/uploads/media_library/{year}/{month}/{file_name}', [ImageController::class, 'showMediaImage'])->where('year', '[0-9]{4}')->where('month', '[0-9]{2}');
Route::get('/images/assets/img/{file_name}', [ImageController::class, 'showAssetImage']);
