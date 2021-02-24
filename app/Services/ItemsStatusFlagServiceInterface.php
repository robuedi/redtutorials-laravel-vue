<?php

namespace App\Services;

interface ItemsStatusFlagServiceInterface
{
    public function checkFlag(?int $status);
}
