<?php


namespace App\Http\Controllers;

use App\Repositories\CourseRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\ModelCollectionService;
use App\Services\SEO\MetaDescriptionServiceInterface;
use App\Services\UserProgress\ChapterStatusInterface;

class TutorialsController extends Controller
{
    private CourseRepositoryInterface $course_repository;
    private ChapterStatusInterface $chapter_status;
    private AuthenticationServiceInterface $authentication_service;
    private MetaDescriptionServiceInterface $meta_description_service;

    public function __construct(CourseRepositoryInterface $course_repository, ChapterStatusInterface $chapter_status, AuthenticationServiceInterface $authentication_service, MetaDescriptionServiceInterface $meta_description_service)
    {
        $this->course_repository        = $course_repository;
        $this->chapter_status           = $chapter_status;
        $this->authentication_service   = $authentication_service;
        $this->meta_description_service = $meta_description_service;
    }

    public function showChapters(string $course_slug)
    {
        $course_info = $this->course_repository->getPublicBySlugWith($course_slug, ['publicChapters:id,course_id,name,slug', 'publicChapters.publicLessons:id,chapter_id,name,slug', 'mediaFilesMain:url'], ['name', 'id', 'description', 'slug']);

        if(!$course_info)
        {
            abort(404);
        }

        $this->chapter_status
            ->setIDs($course_info->publicChapters->pluck('id')->toArray())
            ->setUserID(3);

        return view('tutorials.chapters', [
            'course'        => $course_info,
            'status_chapters'  => $this->chapter_status->getStatus(true),
            'status_lessons'  => $this->chapter_status->getLessonsStatus()->getStatus(true),
            'meta_description'  => $this->meta_description_service->getCourseDescription($course_info->name, $course_info->meta_description, $course_info->publicChapters->pluck('name')->toArray())
        ]);
    }
}
