<?php


namespace App\Services\UserProgress;


use App\Repositories\CourseRepositoryInterface;
use App\Repositories\LessonSectionRepositoryInterface;
use App\Repositories\LessonSectionUserRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;

class CourseStatus implements CourseStatusInterface
{
    private LessonSectionUserRepositoryInterface $user_lesson_section_repository;
    private LessonSectionRepositoryInterface $lesson_section_repository;
    private CourseRepositoryInterface $course_repository;
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(LessonSectionUserRepositoryInterface $user_lesson_section_repository, LessonSectionRepositoryInterface $lesson_section_repository, CourseRepositoryInterface $course_repository, AuthenticationServiceInterface $authentication_service)
    {
        $this->lesson_section_repository = $lesson_section_repository;
        $this->user_lesson_section_repository = $user_lesson_section_repository;
        $this->course_repository = $course_repository;
        $this->authentication_service = $authentication_service;
    }

    public function getCourseStatus(int $course_id, int $user_id, bool $floor_rounded = true)
    {
        //get all the sections completed be user for the course
        $user_sections = $this->user_lesson_section_repository->countByCourse($user_id, $course_id);

        //get all the sections from course
        $all_sections = $this->lesson_section_repository->countByCourse($course_id);

        if($all_sections === 0 || $user_sections === 0)
        {
            $completion_percentage = 0;
        }
        else
        {
            $completion_percentage = ($user_sections*100)/$all_sections;
        }

        //get percentage
        if($floor_rounded)
        {
            $completion_percentage = (int)$completion_percentage;
        }

        return $completion_percentage;
    }

    public function getCoursesStatus()
    {

        $user_id = $this->authentication_service->getUserId();

        if(!$user_id)
        {
            return collect([]);
        }

        $courses = $this->course_repository->getByStatus([1], ['id','name', 'slug', 'short_description', 'status']);

        foreach ($courses as $course)
        {
            $course->completion_percentage = $this->getCourseStatus($course->id, $user_id);
        }

        return $courses ?? collect([]);
    }

    public function getAllCoursesWithUserStatus(){

        $courses = $this->course_repository->getByStatus([1,2], ['id','name', 'slug', 'short_description', 'status']);

        $user_id = $this->authentication_service->getUserId();

        //add info
        foreach ($courses as $course)
        {
            //add progress
            if($course->status == 2||!$user_id)
                continue;

            $course->completion_status = $this->getCourseStatus($course->id, $user_id);
        }

        return $courses;
    }
}
