<?php

namespace App\Repositories;

interface LoginSessionRepositoryInterface
{
    public function saveLogin(int $user_id): void;

    public function saveLogout(): void;
}
