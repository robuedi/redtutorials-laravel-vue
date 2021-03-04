<?php


namespace App\Services\Authentication\Components;

use App\Repositories\LoginSessionRepositoryInterface;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

class AuthenticationLogin implements AuthenticationLoginInterface
{
    private LoginSessionRepositoryInterface $login_session_repository;
    public function __construct(LoginSessionRepositoryInterface $login_session_repository)
    {
        $this->login_session_repository = $login_session_repository;
    }

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
            if($this->hasAcces($intended_roles))
            {
                //save the login session
                $this->login_session_repository->saveLogin($logged_user->getUserId());

                //set response
                $response['status'] = true;
                $response['user'] = $logged_user;
                return $response;
            }

            $this->logout();
            $response['status'] = 'Login not authorised.';
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
        //save logout action
        $this->login_session_repository->saveLogout();
        return Sentinel::logout();
    }
}
