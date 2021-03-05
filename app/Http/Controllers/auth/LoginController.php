<?php


namespace App\Http\Controllers\auth;

use App\Http\Requests\admin\LoginRequest;
use App\Services\Authentication\Facade\AuthenticationFacadeInterface;

class LoginController
{
    private AuthenticationFacadeInterface $authentication_facade;

    public function __construct(AuthenticationFacadeInterface $authentication_facade)
    {
        $this->authentication_facade = $authentication_facade;
    }

    public function login(LoginRequest $request)
    {
        //make login
        $login_status = $this->authentication_facade->login(['client'], $request->get('email'),$request->get('password'),$request->get('remember'));

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
        if(!$this->authentication_facade->logout()){
            return response()->redirectTo('/profile')->withErrors(['Unable to logout.']);
        }

        return response()->redirectTo('/');
    }
}
