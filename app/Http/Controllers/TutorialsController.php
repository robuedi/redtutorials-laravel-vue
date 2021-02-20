<?php


namespace App\Http\Controllers;


use App\Repositories\CourseRepositoryInterface;
use App\Services\CoursesServiceInterface;

class TutorialsController
{
    private CourseRepositoryInterface $course_repository;
    public function __construct(CourseRepositoryInterface $course_repository)
    {
        $this->course_repository = $course_repository;
    }

    public function showChapters(string $course_slug)
    {
        $course_info = $this->course_repository->getBySlugWith($course_slug, [1], ['publicChapters:name,slug', 'publicChapters.publicLessons', 'mediaFilesMain'], ['name', 'id', 'description', 'slug']);

        return view('tutorials.chapters', [
            'course'        => $course_info,
            'meta_description'  => '',
        ]);
    }


}
