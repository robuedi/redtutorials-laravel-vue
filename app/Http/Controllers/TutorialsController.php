<?php


namespace App\Http\Controllers;

use App\Repositories\CourseRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\UserProgress\ChapterStatusInterface;
use App\Services\UserProgress\CourseStatusInterface;
use App\Services\UserProgress\LessonStatus;

class TutorialsController extends Controller
{
    private CourseRepositoryInterface $course_repository;
    private CourseStatusInterface $course_status;
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(CourseRepositoryInterface $course_repository, CourseStatusInterface $course_status, AuthenticationServiceInterface $authentication_service)
    {
        $this->course_repository    = $course_repository;
        $this->course_status        = $course_status;
        $this->authentication_service = $authentication_service;
    }

    public function showChapters(string $course_slug)
    {
        $course_info = $this->course_repository->getPublicBySlugWith($course_slug, ['publicChapters:id,course_id,name,slug', 'publicChapters.publicLessons:id,chapter_id,name,slug', 'mediaFilesMain:url'], ['name', 'id', 'description', 'slug']);

        if(!$course_info)
        {
            abort(404);
        }

        // get status for chapters and lessons
        $status_chapters =$this->course_status
                                ->setIDs([$course_info->id])
                                ->setUserID(3)
                                ->getChaptersStatus()
                                ->getStatus(true);

        // get status for lessons
        $status_lessons = $this->course_status
                                ->getChaptersStatus()
                                ->getLessonsStatus()
                                ->getStatus(true);

        return view('tutorials.chapters', [
            'course'        => $course_info,
            'status_chapters'  => $status_chapters,
            'status_lessons'  => $status_lessons,
            'meta_description'  => '',
        ]);
    }
}
