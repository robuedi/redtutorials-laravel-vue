<?php

namespace App\Repositories;

interface LessonSectionRepositoryInterface
{
    public function countByCourse(int $course_id);
}
