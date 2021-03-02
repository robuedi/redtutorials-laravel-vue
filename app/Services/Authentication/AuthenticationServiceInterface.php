<?php


namespace App\Services\Authentication;


interface AuthenticationServiceInterface
{
    /**
     * Login user
     * @param string|null $email
     * @param string|null $password
     * @param bool|null $remember
     */
    public function doLogin(?string $email, ?string $password, ?bool $remember);

    /**
     * user logout
     */
    public function logout(): bool;

    /**
     * get current logged user id
     * @return int|null
     */
    public function getUserId();

    public function getUserName() : string;
    public function getUserFirstName() : string;

    /**
     * Check if admin user logged
     * @return string
     */
    public function checkIfAdmin(): string;

    /**
     * Get logged user
     * @return \Cartalyst\Sentinel\Users\UserInterface|null
     */
    public function userLogged();

    /**
     * Check if logged user is admin
     * @return mixed
     */
    public function hasAcces(array $type);
}
