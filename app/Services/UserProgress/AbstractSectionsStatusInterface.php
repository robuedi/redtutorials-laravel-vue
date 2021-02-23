<?php

namespace App\Services\UserProgress;

interface AbstractSectionsStatusInterface
{
    public function setIDs(array $ids = []);

    public function setUserID(?int $user_id);

    public function setFloorRounded(bool $floor_rounded);

    public function getStatus();
}
