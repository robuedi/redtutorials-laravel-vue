<?php


namespace App\Repositories;

use App\Models\UserLessonSection;

class UserLessonSectionRepository implements UserLessonSectionRepositoryInterface
{
    public function countByCourse(int $user_id, int $course_id)
    {
        return UserLessonSection::join('lessons_sections', 'lessons_sections.id', '=', 'users_to_lessons_sections.lesson_section_id')
            ->join('lessons', 'lessons.id', '=', 'lessons_sections.lesson_id')
            ->join('chapters', 'chapters.id', '=', 'lessons.chapter_id')
            ->join('courses', 'courses.id', '=', 'chapters.course_id')
            ->where('lessons_sections.is_public',1)
            ->where('lessons_sections.type','quiz')
            ->where('lessons.is_public',1)
            ->where('chapters.is_public',1)
            ->where('courses.status',1)
            ->where('courses.id', $course_id)
            ->where('users_to_lessons_sections.user_id', $user_id)
            ->get()
            ->count();
    }
}
