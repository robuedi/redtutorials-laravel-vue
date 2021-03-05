<?php


namespace App\Services\Authentication;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class AuthenticationService implements AuthenticationServiceInterface
{
    private $logged_user = null;

    public function getUserId() : ?int
    {
        if($this->getUserLogged())
        {
            return $this->getUserLogged()->getUserId();
        }

        return null;
    }

    public function getUserName() : string
    {
        if($this->getUserLogged())
        {
            return $this->getUserLogged()->first_name.' '.$this->getUserLogged()->last_name;
        }

        return '';
    }

    public function getUserFirstName() : string
    {
        if($this->getUserLogged())
        {
            return $this->getUserLogged()->first_name;
        }

        return '';
    }

    public function checkIfAdmin() : string
    {
        return $this->checkIfRoles(['admin']);
    }

    public function checkIfClient() : string
    {
        return $this->checkIfRoles(['client']);
    }

    public function checkIfRoles(array $roles) : string
    {
        try {
            if ($this->getUserLogged() && $this->hasAccess($roles))
                return 'yes';
            else
                return 'no';
        } catch (NotActivatedException $e) {
            return 'inactivated';
        }
    }

    public function getUserLogged()
    {
        if($this->logged_user)
        {
            return $this->logged_user;
        }

        //get user
        $this->logged_user = Sentinel::getUser();

        if(!$this->logged_user)
        {
            return null;
        }

        return $this->logged_user;
    }

    public function hasAccess(array $type) : bool
    {
        return Sentinel::hasAccess($type);
    }

}
