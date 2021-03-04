<?php

namespace App\Services\Authentication\Facade;

use App\Services\Authentication\Components\AuthenticationLoginInterface;
use App\Services\Authentication\Components\AuthenticationRegisterInterface;

interface AuthenticationInterface extends AuthenticationLoginInterface, AuthenticationRegisterInterface
{
}
