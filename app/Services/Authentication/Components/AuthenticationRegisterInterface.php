<?php

namespace App\Services\Authentication\Components;

interface AuthenticationRegisterInterface
{
    public function register(string $user_type, array $user_info);
    public function activateAccount(int $user_id, string $activation_code);
}
