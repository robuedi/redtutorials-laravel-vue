<?php


namespace App\Services\Authentication;

use App\Repositories\LoginRepository;
use App\Repositories\LoginRepositoryInterface;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class AuthenticationService implements AuthenticationServiceInterface
{
    use AuthenticationLogin, AuthenticationLogout;

    private $logged_user;
    private $has_access = [];

    public function getLoggedUserId()
    {
        if($this->userLogged())
        {
            return $this->userLogged()->getUserId();
        }

        return null;
    }

    public function checkIfAdmin() : string
    {
        try {
            if ($this->userLogged() && $this->hasAdminAcces())
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

    public function hasAdminAcces()
    {
        if(!isset($this->has_access['admin'])&& $this->has_access['admin'] === true)
        {
            $this->has_access['admin'] = Sentinel::hasAccess('admin');
        }

        return $this->has_access['admin'];
    }

}
