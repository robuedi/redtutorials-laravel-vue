<?php


namespace App\Services\Progress\Facade;


use App\Services\Authentication\AuthenticationHelperInterface;
use App\Services\Progress\CourseProgressInterface;
use Illuminate\Database\Eloquent\Collection;

class CourseProgressHelper implements CourseProgressHelperInterface
{
    private CourseProgressInterface $course_progress;
    private AuthenticationHelperInterface $authentication_helper;

    public function __construct(CourseProgressInterface $course_progress, AuthenticationHelperInterface $authentication_helper)
    {
        $this->course_progress = $course_progress;
        $this->authentication_helper = $authentication_helper;
    }

    public function appendStatusToCourses(Collection $courses)
    {
        //get the progress
        $progress = $this->course_progress
            ->setUsersIDs([$this->authentication_helper->getUserId()])
            ->setIDs($courses->map(function ($item){
                return $item->id;
            })->toArray())
            ->getProgress(true);

        //append the progress to the courses
        $courses->each(function ($item) use (&$progress){
            //check if course started already
            $item->progress = $progress->getFor($item->id);
        });

        return $courses;
    }
}
