<?php

namespace App\Services\Progress;

use App\Services\Progress\Decorator\Progress;
use App\Services\Progress\Wrapper\ProgressWrapperInterface;

interface LessonProgressInterface
{
    public function setIDs(array $ids): Progress;

    public function setUsersIDs(array $users_id): Progress;

    public function getProgress(): ProgressWrapperInterface;

    public function getChildren() : Progress;
}
