<?php

namespace App\Services\UserProgress;

interface ChapterStatusInterface
{
    public function setUserID(?int $user_id);

    public function setChaptersIDs(array $chapters_id = []);

    public function setFloorRounded(bool $floor_rounded);

    public function getStatus();

    public function getLessonsStatus();
}
