<?php


namespace App\Repositories;

use App\Models\LessonSection;
use App\Models\LessonSectionUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LessonSectionUserRepository implements LessonSectionUserRepositoryInterface
{
    public function countByCourse(int $user_id, int $course_id)
    {
        return LessonSectionUser::join('lesson_sections', 'lesson_sections.id', '=', 'user_lesson_section.lesson_section_id')
            ->join('lessons', 'lessons.id', '=', 'lesson_sections.lesson_id')
            ->join('chapters', 'chapters.id', '=', 'lessons.chapter_id')
            ->join('courses', 'courses.id', '=', 'chapters.course_id')
            ->where('lesson_sections.is_public',1)
            ->where('lesson_sections.type','quiz')
            ->where('lessons.is_public',1)
            ->where('chapters.is_public',1)
            ->where('courses.status',1)
            ->where('courses.id', $course_id)
            ->where('user_lesson_section.user_id', $user_id)
            ->select('user_lesson_section.id')
            ->get()
            ->count();
    }

    public function countLessonSectionUserByLessons(int $user_id, array $lessons_id, int $is_public, string $type)
    {
        return LessonSection::whereHas('users', function($query) use (&$user_id){
                $query->where('users.id', $user_id);
            })
            ->where('is_public', $is_public)
            ->where('type', $type)
            ->whereIn('lesson_id', $lessons_id)
            ->select('lesson_id', DB::raw('count(*) as total'))
            ->groupBy('lesson_id')
            ->pluck('total', 'lesson_id');
    }
}
