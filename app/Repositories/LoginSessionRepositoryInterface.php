<?php

namespace App\Repositories;

use App\Services\Authentication\AuthenticationServiceInterface;

interface LoginSessionRepositoryInterface
{
    public function saveLogin(int $user_id): void;

    public function saveLogout(): void;
}
