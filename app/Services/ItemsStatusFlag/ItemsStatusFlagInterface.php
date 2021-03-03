<?php

namespace App\Services\ItemsStatusFlag;

interface ItemsStatusFlagInterface
{
    public function checkFlag(?int $status);
}
