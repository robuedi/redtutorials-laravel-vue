<?php


namespace App\Services\Authentication\Facade\Components;

use App\Services\Authentication\Facade\AuthenticationLoginInterface;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

class AuthenticationLogin implements AuthenticationLoginInterface
{

    public function login(array $intended_roles, string $email, string $password, ?bool $remember)
    {
        $response = [
            'status' => false,
            'msg' => '',
            'user' => null
        ];

        try {
            $remember = (bool)$remember;

            //try user login
            $logged_user = Sentinel::authenticate(['email'=> $email, 'password' => $password], $remember);

            // check if login succeeded
            if(!$logged_user)
            {
                $response['msg'] = 'Invalid login or password.';
                return $response;
            }

            //check if correct role
            if(Sentinel::hasAccess($intended_roles))
            {
                //set response
                $response['status'] = true;
                $response['user'] = $logged_user;
                return $response;
            }

            $this->logout();
            $response['msg'] = 'Login not authorised.';
        } catch (NotActivatedException $e) {
            $response['msg'] = 'Account is not activated!';
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $response['msg'] = "Your account is blocked for {$delay} second(s).";
        }

        return $response;
    }

    public function logout() : bool
    {
        //do logout
        return Sentinel::logout();
    }
}
