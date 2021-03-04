<?php

namespace App\Services\Authentication\Components;

interface AuthenticationLoginInterface
{
    public function login(array $intended_roles, string $email, string $password, ?bool $remember);

    public function logout(): bool;
}
