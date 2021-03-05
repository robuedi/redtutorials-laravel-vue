<?php

namespace App\Services\Authentication\Facade;

use App\Services\Authentication\Components\AuthenticationLoginInterface;
use App\Services\Authentication\Components\AuthenticationRegisterInterface;

interface AuthenticationFacadeInterface
{
    public function login(array $intended_roles, string $email, string $password, ?bool $remember);

    public function logout(): bool;

    public function register(string $user_type, array $user_info, string $base_activation_url);

    public function activateAccount(int $user_id, string $activation_code);
}
