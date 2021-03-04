<?php


namespace App\Http\Controllers\auth;

use App\Http\Requests\admin\LoginRequest;
use App\Services\Authentication\AuthenticationServiceInterface;

class LoginController
{
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(AuthenticationServiceInterface $authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    public function login(LoginRequest $request)
    {
        //make login
        $login_status = $this->authentication_service->login(['client'], $request->get('email'),$request->get('password'),$request->get('remember'));

        //check login status
        if(!$login_status['status'])
        {
            return redirect()->back()->withInput()->withErrors($login_status['msg']);
        }

        return response()->redirectToIntended('/profile');
    }

    function logout()
    {
        //do logout
        if(!$this->authentication_service->logout()){
            return response()->redirectTo('/profile')->withErrors(['Unable to logout.']);
        }

        return response()->redirectTo('/');
    }
}
