<?php


namespace App\Http\Controllers;

use App\Repositories\CourseRepositoryInterface;
use App\Repositories\LessonRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\SEO\MetaDescriptionServiceInterface;
use App\Services\UserProgress\ChapterStatusInterface;
use App\Services\UserProgress\LessonSectionUserStatusInterface;

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

    public function showCourseContent(string $course_slug)
    {
        $course_info = $this->course_repository->getPublicBySlugWith($course_slug, ['publicChapters:id,course_id,name,slug', 'publicChapters.publicLessons:id,chapter_id,name,slug', 'mediaFilesMain:url'], ['name', 'id', 'description', 'slug']);

        if(!$course_info)
        {
            abort(404);
        }

        $this->chapter_status
            ->setIDs($course_info->publicChapters->pluck('id')->toArray())
            ->setUserID($this->authentication_service->getUserId());

        return view('tutorials.course-content', [
            'course'        => $course_info,
            'status_chapters'  => $this->chapter_status->getStatus(true),
            'status_lessons'  => $this->chapter_status->getLessonsStatus()->getStatus(true),
            'meta_description'  => $this->meta_description_service->getCourseDescription($course_info->name, $course_info->meta_description, $course_info->publicChapters->pluck('name')->toArray())
        ]);
    }

    public function showLessonContent(string $course_slug, string $chapter_slug, string $lesson_slug, LessonRepositoryInterface $lesson_repository, LessonSectionUserStatusInterface $lesson_section_user_status)
    {
        //get the lesson
        $lesson = $lesson_repository->getLessonByCourseChapterLessonSlugs(
            $course_slug, $chapter_slug, $lesson_slug,
            ['chapter_id', 'order_weight','id','name'],
            [ 'publicLessonSections', 'publicLessonSections.publicLessonSectionOptions', 'publicChapter:id,name,slug,course_id', 'publicChapter.publicCourse:id,name,slug', 'publicChapter.publicCourse.mediaFilesMain:url']
        );

        //return 404 if not found
        if(!$lesson)
        {
            abort(404);
        }

        $lesson_sections_status = $lesson_section_user_status
                            ->setIDs($lesson->publicLessonSections->pluck('id')->toArray())
                            ->setUserID($this->authentication_service->getUserId())
                            ->getStatus();

        return view('tutorials.lesson_content', [
            'course_slug'           => '/'.$course_slug,
            'lesson'                => $lesson,
            'next_lesson'           => $lesson->next(),
            'meta_description'      => '',
            'lesson_sections_status'=> $lesson_sections_status,
            'user'                  => $this->authentication_service->userLogged()
        ]);
    }
}
