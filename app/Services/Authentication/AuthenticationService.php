<?php


namespace App\Services\Authentication;

use App\Services\Authentication\Facade\AuthenticationFacade;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class AuthenticationService extends AuthenticationFacade implements AuthenticationServiceInterface
{
    private $logged_user = null;

    public function getUserId() : ?int
    {
        if($this->userLogged())
        {
            return $this->userLogged()->getUserId();
        }

        return null;
    }

    public function getUserName() : string
    {
        if($this->userLogged())
        {
            return $this->userLogged()->first_name.' '.$this->userLogged()->last_name;
        }

        return '';
    }

    public function getUserFirstName() : string
    {
        if($this->userLogged())
        {
            return $this->userLogged()->first_name;
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
            if ($this->userLogged() && $this->hasAcces($roles))
                return 'yes';
            else
                return 'no';
        } catch (NotActivatedException $e) {
            return 'inactivated';
        }
    }

    public function userLogged()
    {
        if(!$this->user_logged)
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

    public function hasAcces(array $type) : bool
    {
        return Sentinel::hasAccess($type);
    }

}
