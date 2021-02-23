<?php

namespace App\Repositories;

interface LessonSectionRepositoryInterface
{
    public function countByLessons(array $lessons_id, int $is_public, string $type);
}
