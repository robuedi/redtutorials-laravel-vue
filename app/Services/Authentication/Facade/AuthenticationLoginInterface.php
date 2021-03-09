<?php

namespace App\Services\Authentication\Facade;

interface AuthenticationLoginInterface
{
    public function login(array $intended_roles, string $email, string $password, ?bool $remember);

    public function logout(): bool;
}
