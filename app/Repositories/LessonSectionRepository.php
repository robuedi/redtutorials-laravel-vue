<?php


namespace App\Repositories;


use App\Models\LessonSection;

class LessonSectionRepository implements LessonSectionRepositoryInterface
{
    public function countByCourse(int $course_id)
    {
        return LessonSection::join('lessons', 'lessons.id', '=', 'lesson_sections.lesson_id')
            ->join('chapters', 'chapters.id', '=', 'lessons.chapter_id')
            ->join('courses', 'courses.id', '=', 'chapters.course_id')
            ->where('lesson_sections.is_public',1)
            ->where('lesson_sections.type','quiz')
            ->where('lessons.is_public',1)
            ->where('chapters.is_public',1)
            ->where('courses.status',1)
            ->where('courses.id', $course_id)
            ->select('lesson_sections.id')
            ->get('lesson_sections.id')
            ->count();
    }
}
