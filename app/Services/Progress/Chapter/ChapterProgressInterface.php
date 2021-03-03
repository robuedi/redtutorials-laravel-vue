<?php

namespace App\Services\Progress\Chapter;

use App\Services\Progress\Progress;

interface ChapterProgressInterface
{
    public function setIDs(array $ids): Progress;

    public function setUsersIDs(array $users_id): Progress;

    public function getProgress(): array;
}
