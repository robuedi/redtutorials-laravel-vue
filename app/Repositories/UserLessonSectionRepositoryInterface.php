<?php

namespace App\Repositories;

interface UserLessonSectionRepositoryInterface
{
    public function countByCourse(int $user_id, int $course_id);
}
