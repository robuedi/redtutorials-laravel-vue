<?php

namespace App\Services\Authentication\Components;

interface AuthenticationRegisterInterface
{
    public function register(string $user_type, array $user_info);
}
