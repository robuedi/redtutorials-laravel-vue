<?php


namespace App\Services\Authentication\Components;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;

class AuthenticationRegister implements AuthenticationRegisterInterface
{
    public function register(string $user_type, array $user_info)
    {
        $response = [
            'status'    => 'fail',
            'msg'       => ''
        ];

        //get role
        $role = Sentinel::findRoleBySlug($user_type);

        if(!$role)
        {
            $response['msg'] = 'Role missing';
            return $response;
        }

        //register
        $user = Sentinel::register($user_info);
        $user->save();

        // assign user to  role
        $role->users()->attach($user);

        return [
            'status'    => 'success',
            'user'      => $user
        ];
    }

    public function makeActivationCode(UserInterface $user)
    {
        return Activation::create($user);
    }
}
