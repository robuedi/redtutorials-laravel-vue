<?php


namespace App\Services\Authentication;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

trait AuthenticationLogin
{
    private string $login_msg = '';

    public function doLogin(?string $email, ?string $password, ?bool $remember)
    {
        try {
            $remember = (bool)$remember;

            //try user login
            $this->logged_user = Sentinel::authenticate(['email'=> $email, 'password' => $password], $remember);
            // check if login succeeded
            if($this->logged_user)
            {
                return true;
            }

            $this->login_msg = 'Invalid login or password.';

        } catch (NotActivatedException $e) {
            $this->login_msg = 'Account is not activated!';

        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $this->login_msg = "Your account is blocked for {$delay} second(s).";
        }

        return false;
    }

    public function getLoginMsg(){
        return $this->login_msg;
    }
}
