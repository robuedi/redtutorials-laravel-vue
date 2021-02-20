<?php


namespace App\Services\Authentication;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class AuthenticationService implements AuthenticationServiceInterface
{
    use AuthenticationLogin, AuthenticationLogout;

    private $logged_user;
    private $has_access = [];

    /**
     * get current logged user id
     * @return int|null
     */
    public function getLoggedUserId()
    {
        if($this->userLogged())
        {
            return $this->userLogged()->getUserId();
        }

        return null;
    }

    /**
     * Check if admin user logged
     * @return string
     */
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

    /**
     * Get logged user
     * @return \Cartalyst\Sentinel\Users\UserInterface|null
     */
    public function userLogged()
    {
        if(!isset($this->user_logged))
        {
            $this->logged_user = Sentinel::getUser();
        }

        return $this->logged_user;
    }

    /**
     * Check if logged user is admin
     * @return mixed
     */
    public function hasAcces(string $type)
    {
        if(!isset($this->has_access[$type]))
        {
            $this->has_access[$type] = Sentinel::hasAccess($type);
        }

        return $this->has_access[$type];
    }

}
