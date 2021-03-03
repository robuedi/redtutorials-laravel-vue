<?php

namespace App\Services\Progress;

use App\Services\Progress\Decorator\Progress;

interface CourseProgressInterface
{
    public function setIDs(array $ids): Progress;

    public function setUsersIDs(array $users_id): Progress;

    public function getProgress(): array;

    public function getChildren() : Progress;
}
