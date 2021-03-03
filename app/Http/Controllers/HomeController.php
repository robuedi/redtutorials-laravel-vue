<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\Progress\CourseProgressInterface;

class HomeController
{
    private CourseProgressInterface $course_progress;
    private CourseRepositoryInterface $course_repository;
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(CourseRepositoryInterface $course_repository, CourseProgressInterface $course_progress, AuthenticationServiceInterface $authentication_service)
    {
        $this->course_progress = $course_progress;
        $this->course_repository = $course_repository;
        $this->authentication_service = $authentication_service;
    }

    public function index()
    {
        //get courses
        $courses = $this->course_repository->getPublic(['id', 'name', 'slug', 'is_public', 'short_description']);

        //get progress
        $courses_ids = $courses->map(function ($item){
            return $item->id;
        });

        return view('home', [
            'courses'           => $courses,
            'course_progress'   => $this->course_progress
                                    ->setUsersIDs([$this->authentication_service->getUserId()])
                                    ->setIDs($courses_ids->toArray())
                                    ->getProgress(true)
        ]);
    }

}
