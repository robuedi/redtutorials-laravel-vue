<?php


namespace App\Services\Authentication;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

trait AuthenticationLogout
{
    public function logout()
    {
        Sentinel::logout();
    }

}
