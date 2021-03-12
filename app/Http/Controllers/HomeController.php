<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepositoryInterface;
use App\Services\Authentication\AuthenticationHelperInterface;
use App\Services\Progress\CourseProgressInterface;
use App\Services\Progress\Facade\CourseProgressHelperInterface;

class HomeController
{
    public function index()
    {
        return view('home');
    }
}
