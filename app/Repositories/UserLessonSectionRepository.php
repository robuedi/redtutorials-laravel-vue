<?php


namespace App\Repositories;

use App\Models\UserLessonSection;

class UserLessonSectionRepository implements UserLessonSectionRepositoryInterface
{
    public function countByCourse(int $user_id, int $course_id)
    {
        return UserLessonSection::join('lesson_sections', 'lesson_sections.id', '=', 'user_lesson_section.lesson_section_id')
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
}
