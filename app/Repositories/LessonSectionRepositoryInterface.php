<?php

namespace App\Repositories;

interface LessonSectionRepositoryInterface
{
    public function countByLessons(array $lessons_id, bool $is_public, string $type);
}
