<?php

namespace App\Services\Authentication\Components;

use Cartalyst\Sentinel\Users\UserInterface;

interface AuthenticationRegisterInterface
{
    public function register(string $user_type, array $user_info);
    public function makeActivationCode(UserInterface $user);
    public function activateAccount(int $user_id, string $activation_code) : array;
}
