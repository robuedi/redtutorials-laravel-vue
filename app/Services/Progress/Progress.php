<?php


namespace App\Services\Progress;

interface Progress
{
    public function setIDs(array $ids) : Progress;

    public function setUsersIDs(array $users_id) : Progress;

    public function getIDs() : array;

    public function getProgress(bool $floor = false) : array;

    public function getUsersIDs(): array;
}
