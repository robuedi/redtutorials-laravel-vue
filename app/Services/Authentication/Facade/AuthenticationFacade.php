<?php


namespace App\Services\Authentication\Facade;

 use App\Services\Authentication\Components\AuthenticationLoginInterface;
 use App\Services\Authentication\Components\AuthenticationRegisterInterface;

 class AuthenticationFacade implements AuthenticationInterface
{
    protected AuthenticationRegisterInterface $authentication_register;
    protected AuthenticationLoginInterface $authentication_login;

    public function __construct(AuthenticationRegisterInterface $authentication_register, AuthenticationLoginInterface $authentication_login)
    {
        $this->authentication_register = $authentication_register;
        $this->authentication_login = $authentication_login;

    }

     public function login(array $intended_roles, string $email, string $password, ?bool $remember)
     {
         return $this->authentication_login->login($intended_roles, $email, $password, $remember);
     }

     public function logout(): bool
     {
         return $this->authentication_login->logut();
     }

     public function register(string $user_type, array $user_info, string $base_activation_url)
     {
         return $this->authentication_register->register($user_type, $user_info, $base_activation_url);
     }
 }
