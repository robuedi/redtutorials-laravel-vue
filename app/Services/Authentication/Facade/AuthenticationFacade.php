<?php


namespace App\Services\Authentication\Facade;

 use App\Repositories\LoginSessionRepositoryInterface;
 use App\Services\Mailer\MailerInterface;

 class AuthenticationFacade implements AuthenticationFacadeInterface
 {
    private AuthenticationRegisterInterface $authentication_register;
    private AuthenticationLoginInterface $authentication_login;
    private LoginSessionRepositoryInterface $login_session_repository;
    private MailerInterface $mailer;

    public function __construct(AuthenticationRegisterInterface $authentication_register, AuthenticationLoginInterface $authentication_login, LoginSessionRepositoryInterface $login_session_repository, MailerInterface $mailer)
    {
        $this->authentication_register = $authentication_register;
        $this->authentication_login = $authentication_login;
        $this->login_session_repository = $login_session_repository;
        $this->mailer = $mailer;
    }

     public function login(array $intended_roles, string $email, string $password, ?bool $remember)
     {
         //do login
        $login_response = $this->authentication_login->login($intended_roles, $email, $password, $remember);

        //save the login session
        if($login_response['status'])
        {
            $this->login_session_repository->saveLogin($login_response['user']->getUserId());
        }

        return $login_response;
     }

     public function logout(): bool
     {
         //do logout
        $response = $this->authentication_login->logut();

        //save logout action
        if($response)
        {
            $this->login_session_repository->saveLogout();
        }

        return $response;
     }

     public function register(string $user_type, array $user_info, string $base_activation_url)
     {
         $response = $this->authentication_register->register($user_type, $user_info);

         if(!$response['status'])
         {
             return $response;
         }

         //get user
         $user = $response['user'];

         //make activation url
         $activation_url = $base_activation_url.'/'.$user->id.'/'.$this->authentication_register->makeActivationCode($user)->code;

         //send activation email
         if(env('APP_ENV') === 'production')
         {
             $this->mailer->sendActivationEmail($activation_url, $user->email, $user->first_name, $user->last_name);
         }
         else
         {
             // log for dev support
             info($activation_url);
         }

         return $response;
     }

     public function activateAccount(int $user_id, string $activation_code)
     {
         return $this->authentication_register->activateAccount($user_id, $activation_code);
     }
 }
