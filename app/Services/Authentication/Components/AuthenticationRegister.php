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
            'status'    => false,
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
            'status'    => true,
            'user'      => $user
        ];
    }

    public function makeActivationCode(UserInterface $user)
    {
        return Activation::create($user);
    }

    public function activateAccount(int $user_id, string $activation_code)
    {
        $response = [
            'status'    => false,
            'user'      => null,
            'msg'       => ''
        ];

        //get the user
        $user = Sentinel::findById($user_id);

        //user not found
        if(!$user)
        {
            $response['msg'] = 'User not found';
            return $response;
        }


        //try to activate user
        if(!Activation::complete($user, $activation_code))
        {
            $response['msg']    = 'Activation failed.';
            $response['user']   = $user;
            return $response;
        }

        //success
        $response['status'] = true;
        return $response;
    }
}
