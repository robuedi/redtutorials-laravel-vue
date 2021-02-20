<?php


namespace App\Services\Authentication;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

trait AuthenticationLogout
{
    /**
     * user logout
     */
    public function logout()
    {
        Sentinel::logout();
    }

}
