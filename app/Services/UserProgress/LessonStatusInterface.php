<?php

namespace App\Services\UserProgress;

interface LessonStatusInterface
{
    public function setUserID(?int $user_id);

    public function setIDs(array $chapters_id = []);

    public function setFloorRounded(bool $floor_rounded);

    public function getStatus();

}