<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepositoryInterface;
use App\Services\Authentication\AuthenticationHelperInterface;
use App\Services\Progress\CourseProgressInterface;

class HomeController
{
    private CourseProgressInterface $course_progress;
    private CourseRepositoryInterface $course_repository;
    private AuthenticationHelperInterface $authentication_helper;

    public function __construct(CourseRepositoryInterface $course_repository, CourseProgressInterface $course_progress, AuthenticationHelperInterface $authentication_helper)
    {
        $this->course_progress = $course_progress;
        $this->course_repository = $course_repository;
        $this->authentication_helper = $authentication_helper;
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
                                    ->setUsersIDs([$this->authentication_helper->getUserId()])
                                    ->setIDs($courses_ids->toArray())
                                    ->getProgress(true)
        ]);
    }

}
