<?php

namespace App\Services\UserProgress;

interface CourseStatusInterface
{
    public function setChaptersStatus(ChapterStatusInterface $chapter_status) : CourseStatusInterface;
    public function getChaptersStatus() : ChapterStatusInterface;

    public function setIDs(?array $ids): AbstractSectionsStatusInterface;

    public function setUserID(?int $user_id): AbstractSectionsStatusInterface;

    public function getIDs(): ?array;

    public function getUserID(): ?int;

    public function getFreshStatus(bool $floor_rounded = false);

    public function getStatus(bool $floor_rounded = false);
}
