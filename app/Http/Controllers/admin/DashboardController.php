<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Repositories\ChapterRepositoryInterface;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\LessonRepositoryInterface;
use App\Services\CoursesHierarchy\CoursesHierarchyAdminInterface;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(ChapterRepositoryInterface $chapter_repository, CourseRepositoryInterface $course_repository, LessonRepositoryInterface $lesson_repository)
    {
        return view('_admin.dashboard.index', [
            'public_courses'    => $course_repository->getCountPublic(),
            'draft_courses'     => $course_repository->getCountDraft(),
            'total_courses'     => $course_repository->getCountTotal(),
            'public_chapters'   => $chapter_repository->getCountTotal(),
            'draft_chapters'    => $chapter_repository->getCountDraft(),
            'total_chapters'    => $chapter_repository->getCountTotal(),
            'public_lessons'    => $lesson_repository->getCountPublic(),
            'draft_lessons'     => $lesson_repository->getCountDraft(),
            'total_lessons'     => $lesson_repository->getCountTotal()
        ]);
    }
}
