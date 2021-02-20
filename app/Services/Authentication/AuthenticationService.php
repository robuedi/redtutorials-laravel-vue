<?php


namespace App\Services\Authentication;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class AuthenticationService implements AuthenticationServiceInterface
{
    use AuthenticationLogin, AuthenticationLogout;

    private $logged_user;
    private $has_access = [];

    public function getUserId()
    {
        if($this->userLogged())
        {
            return $this->userLogged()->getUserId();
        }

        return null;
    }

    public function getUserName() : string
    {
        if(!$this->userLogged())
        {
            return '';
        }

        return $this->userLogged()->first_name.' '.$this->userLogged()->last_name;
    }

    public function getUserFirstName() : string
    {
        if(!$this->userLogged())
        {
            return '';
        }

        return $this->userLogged()->first_name;
    }

    public function checkIfAdmin() : string
    {
        try {
            if ($this->userLogged() && $this->hasAcces('admin'))
                return 'yes';
            else
                return 'no';
        } catch (NotActivatedException $e) {
            return 'inactivated';
        }
    }

    public function userLogged()
    {
        if(!isset($this->user_logged))
        {
            $this->logged_user = Sentinel::getUser();
        }

        return $this->logged_user;
    }

    public function hasAcces(string $type)
    {
        if(!isset($this->has_access[$type]))
        {
            $this->has_access[$type] = Sentinel::hasAccess($type);
        }

        return $this->has_access[$type];
    }

}
