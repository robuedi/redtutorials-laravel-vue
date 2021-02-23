<?php


namespace App\Http\Controllers;


use App\Repositories\CourseRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\UserProgress\CourseStatusInterface;

class HomeController
{
    private CourseStatusInterface $course_status;
    private CourseRepositoryInterface $course_repository;
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(CourseRepositoryInterface $course_repository, CourseStatusInterface $course_status, AuthenticationServiceInterface $authentication_service)
    {
        $this->course_status = $course_status;
        $this->course_repository = $course_repository;
        $this->authentication_service = $authentication_service;
    }

    public function index()
    {
        //get courses
        $courses = $this->course_repository->getByStatus([1,2], ['id', 'name', 'slug']);

        //get progress
        $courses_ids = [];
        $courses->map(function ($item) use (&$courses_ids){
            $courses_ids[] = $item->id;
        });
        $this->course_status->setUserID($this->authentication_service->getUserId())
            ->setIDs($courses_ids);

        return view('home', [
            'courses'           => $courses,
            'courses_status'    => $this->course_status->getStatus(),
            'hide_all_tutorials'  => true
        ]);
    }

}
