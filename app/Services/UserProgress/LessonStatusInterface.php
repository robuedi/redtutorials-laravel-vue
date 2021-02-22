<?php

namespace App\Services\UserProgress;

interface LessonStatusInterface
{
    public function setUserID(int $user_id);

    public function setLessonsIDs(array $lessons_id = []);

    public function setFloorRounded(bool $floor_rounded);

    public function getStatus();
}
