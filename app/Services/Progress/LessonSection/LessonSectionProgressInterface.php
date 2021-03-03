<?php

namespace App\Services\Progress;

interface LessonSectionProgressInterface
{
    public function setIDs(array $ids): Progress;

    public function setUsersIDs(array $users_id): Progress;

    public function getProgress(): array;
}