<?php

namespace App\Services\UserProgress;

interface AbstractSectionsStatusInterface
{
    public function setIDs(?array $ids): AbstractSectionsStatusInterface;

    public function setUserID(?int $user_id): AbstractSectionsStatusInterface;

    public function getIDs(): ?array;

    public function getUserID(): ?int;

    public function getFreshStatus(bool $floor_rounded = false);

    public function getStatus(bool $floor_rounded = false);
}
