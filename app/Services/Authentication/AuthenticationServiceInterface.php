<?php

namespace App\Services\Authentication;

interface AuthenticationServiceInterface
{
    public function login(array $intended_roles, string $email, string $password, ?bool $remember);

    public function logout(): bool;

    public function register(string $user_type, array $user_info, string $base_activation_url);

    public function getUserId();

    public function getUserName(): string;

    public function getUserFirstName(): string;

    public function checkIfAdmin(): string;

    public function userLogged();

    public function hasAcces(array $type): bool;
}
