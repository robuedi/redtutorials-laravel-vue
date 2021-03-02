<?php


namespace App\Services\Progress;

interface Progress
{
    public function setIDs(array $ids) : Progress;

    public function setUserID(int $user_id) : Progress;

    public function getIDs() : array;

    public function getProgress() : array;
}
