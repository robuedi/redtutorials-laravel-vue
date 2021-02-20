<?php

namespace App\Repositories;

use App\Services\Authentication\AuthenticationServiceInterface;

interface LoginSessionRepositoryInterface
{
    public function saveLogin(AuthenticationServiceInterface $authentication_service): void;

    public function saveLogout(): void;
}
