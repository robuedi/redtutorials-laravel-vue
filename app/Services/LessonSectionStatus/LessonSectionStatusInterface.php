<?php

namespace App\Services\LessonSectionStatus;

use App\Services\Progress\Wrapper\ProgressWrapperInterface;

interface LessonSectionStatusInterface
{
    public function resetStatus();

    public function checkStatus(ProgressWrapperInterface $progress, int $id, string $type) : int;
}
