<?php

namespace App\Repositories;

interface LessonSectionUserRepositoryInterface
{
    public function countLessonSectionUserByLessons(int $user_id, array $lessons_id, int $is_public, string $type);
}
