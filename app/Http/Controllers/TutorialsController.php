<?php


namespace App\Http\Controllers;

use App\Repositories\CourseRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\UserProgress\ChapterStatusInterface;
use App\Services\UserProgress\LessonStatus;

class TutorialsController extends Controller
{
    private CourseRepositoryInterface $course_repository;
    private ChapterStatusInterface $chapter_status;
    private LessonStatus $lesson_status;
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(CourseRepositoryInterface $course_repository, ChapterStatusInterface $chapter_status, LessonStatus $lesson_status, AuthenticationServiceInterface $authentication_service)
    {
        $this->course_repository = $course_repository;
        $this->chapter_status = $chapter_status;
        $this->lesson_status = $lesson_status;
        $this->authentication_service = $authentication_service;
    }

    public function showChapters(string $course_slug)
    {
        $course_info = $this->course_repository->getBySlugWith($course_slug, [1], ['publicChapters:id,course_id,name,slug', 'publicChapters.publicLessons:id,chapter_id,name,slug', 'mediaFilesMain:url'], ['name', 'id', 'description', 'slug']);

        if(!$course_info)
        {
            abort(404);
        }

        //get chapters status
        $chapters = [];
        $course_info->publicChapters->map(function ($item) use (&$chapters){
            $chapters[] = $item->id;
        });

        // get status for chapters and lessons
        $this->chapter_status
            ->setIDs($chapters)
            ->setUserID($this->authentication_service->getUserId())
            ->setLessonsStatus($this->lesson_status);

        $status_chapters = $this->chapter_status->getStatus();
        $status_lessons = $this->lesson_status->getStatus();

        return view('tutorials.chapters', [
            'course'        => $course_info,
            'status_chapters'  => $status_chapters,
            'status_lessons'  => $status_lessons,
            'meta_description'  => '',
        ]);
    }
}
