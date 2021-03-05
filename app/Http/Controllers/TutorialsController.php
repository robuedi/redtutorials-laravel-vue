<?php


namespace App\Http\Controllers;

use App\Repositories\CourseRepositoryInterface;
use App\Repositories\LessonRepositoryInterface;
use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\LessonSectionStatus\LessonSectionStatusInterface;
use App\Services\Progress\ChapterProgressInterface;
use App\Services\Progress\LessonSectionProgressInterface;
use App\Services\SEO\MetaDescriptionServiceInterface;

class TutorialsController extends Controller
{
    private CourseRepositoryInterface $course_repository;
    private ChapterProgressInterface $chapter_progress;
    private AuthenticationServiceInterface $authentication_service;
    private MetaDescriptionServiceInterface $meta_description_service;
    private LessonRepositoryInterface $lesson_repository;
    private LessonSectionProgressInterface $lesson_section_progress;
    private LessonSectionStatusInterface $lesson_section_status;

    public function __construct(CourseRepositoryInterface $course_repository, ChapterProgressInterface $chapter_progress, AuthenticationServiceInterface $authentication_service, MetaDescriptionServiceInterface $meta_description_service, LessonRepositoryInterface $lesson_repository, LessonSectionProgressInterface $lesson_section_progress, LessonSectionStatusInterface $lesson_section_status)
    {
        $this->course_repository        = $course_repository;
        $this->chapter_progress         = $chapter_progress;
        $this->authentication_service   = $authentication_service;
        $this->meta_description_service = $meta_description_service;
        $this->lesson_repository        = $lesson_repository;
        $this->lesson_section_progress  = $lesson_section_progress;
        $this->lesson_section_status    = $lesson_section_status;
    }

    public function showCourseContent(string $course_slug)
    {
        $course_info = $this->course_repository->getPublicBySlugWith($course_slug, ['publicChapters:id,course_id,name,slug', 'publicChapters.publicLessons:id,chapter_id,name,slug', 'mediaFilesMain:url'], ['name', 'id', 'description', 'slug']);

        if(!$course_info)
        {
            abort(404);
        }

        $current_user = $this->authentication_service->getUserId();
        $this->chapter_progress
            ->setIDs($course_info->publicChapters->pluck('id')->toArray())
            ->setUsersIDs([$current_user]);

        return view('tutorials.course-content', [
            'course'        => $course_info,
            'status_chapters'  => $this->chapter_progress->getProgress(true)->setForUser($current_user)->setPercentage(true),
            'status_lessons'  => $this->chapter_progress->getChildren()->getProgress(true)->setForUser($current_user)->setPercentage(true),
            'meta_description'  => $this->meta_description_service->getCourseDescription($course_info->name, $course_info->meta_description, $course_info->publicChapters->pluck('name')->toArray())
        ]);
    }

    public function showLessonContent(string $course_slug, string $chapter_slug, string $lesson_slug)
    {
        //get the lesson
        $lesson = $this->lesson_repository->getLessonByCourseChapterLessonSlugs(
            $course_slug, $chapter_slug, $lesson_slug,
            ['chapter_id', 'order_weight','id','name'],
            [ 'publicLessonSections', 'publicLessonSections.publicLessonSectionOptions', 'publicChapter:id,name,slug,course_id', 'publicChapter.publicCourse:id,name,slug', 'publicChapter.publicCourse.mediaFilesMain:url']
        );

        //return 404 if not found
        if(!$lesson)
        {
            abort(404);
        }

        $current_user = $this->authentication_service->getUserId();
        $this->lesson_section_progress->setIDs($lesson->publicLessonSections->where('type', 'quiz')->pluck('id')->toArray())
                            ->setUsersIDs([$current_user]);

        return view('tutorials.lesson-content', [
            'course_slug'           => '/'.$course_slug,
            'lesson'                => $lesson,
            'next_lesson'           => $lesson->next(),
            'meta_description'      => '',
            'lesson_sections_progress'=> $this->lesson_section_progress->getProgress(true)->setForUser($current_user),
            'lesson_section_status' => $this->lesson_section_status,
            'user'                  => $this->authentication_service->getUserLogged()
        ]);
    }
}
