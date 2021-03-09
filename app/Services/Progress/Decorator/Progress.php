<?php


namespace App\Services\Progress\Decorator;

use App\Services\Progress\Decorator\Wrapper\ProgressWrapperInterface;

interface Progress
{
    public function setIDs(array $ids) : Progress;

    public function setUsersIDs(array $users_id) : Progress;

    public function getIDs() : array;

    public function getProgress(bool $floor = false) : ProgressWrapperInterface;

    public function getUsersIDs(): array;
}
