<?php

namespace App\Repositories;

interface LessonSectionRepositoryInterface
{
    public function countPublicQuizByLessons(array $lessons_id);
}
