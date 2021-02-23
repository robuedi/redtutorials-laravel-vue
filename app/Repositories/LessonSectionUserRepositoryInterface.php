<?php

namespace App\Repositories;

interface LessonSectionUserRepositoryInterface
{
    public function countPublicQuizByLessons(int $user_id, array $lessons_id);
}
