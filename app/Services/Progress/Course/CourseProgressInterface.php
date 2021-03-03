<?php

namespace App\Services\Progress\Course;

use App\Services\Progress\Progress;

interface CourseProgressInterface
{
    public function setIDs(array $ids): Progress;

    public function setUsersIDs(array $users_id): Progress;

    public function getProgress(): array;
}
