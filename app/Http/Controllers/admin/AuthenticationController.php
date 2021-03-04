<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\LoginRequest;
use App\Services\Authentication\AuthenticationServiceInterface;

class AuthenticationController extends Controller
{
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(AuthenticationServiceInterface $authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    public function login()
    {
        //check if user is logged in as admin
        switch ($this->authentication_service->checkIfAdmin())
        {
            case 'yes':
                return response()->redirectToIntended(config('app.admin_route').'/dashboard');

            case 'no':
                return view('_admin.authentication.login');

            case 'inactivated':
                return view('_admin.authentication.login')->withErrors(['Account not activated.']);
        }
    }

    public function doLogin(LoginRequest $request)
    {
        //make login
        $login_status = $this->authentication_service->login(['admin'], $request->get('email'),$request->get('password'),$request->get('remember'));

        //check login status
        if(!$login_status['status'])
        {
            return redirect()->back()->withInput()->withErrors($login_status['msg']);
        }

        return response()->redirectToIntended(config('app.admin_route').'/dashboard');
    }

    function logout()
    {
        //do logout
        if(!$this->authentication_service->logout()){
            return response()->redirectTo(config('app.admin_route'))->withErrors(['Unable to logout.']);
        }

        return response()->redirectTo(config('app.admin_route'));
    }
}
