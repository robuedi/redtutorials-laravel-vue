<?php


namespace App\Http\Controllers;


use App\Services\UserProgress\CourseStatusInterface;

class HomeController
{
    private $course_status;

    public function __construct(CourseStatusInterface $course_status)
    {
        $this->course_status = $course_status;
    }

    public function index()
    {
        return view('home', [
            'courses'           => $this->course_status->getAllCoursesWithUserStatus(),
            'hide_all_tutorials'  => true
        ]);
    }

}
