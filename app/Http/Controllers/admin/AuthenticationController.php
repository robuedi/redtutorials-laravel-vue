<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\LoginRequest;
use App\Repositories\LoginSessionRepositoryInterface;
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

    public function doLogin(LoginRequest $request, LoginSessionRepositoryInterface $login_session_repository)
    {
        //make login
        $login_status = $this->authentication_service->doLogin($request->get('email'),$request->get('password'),$request->get('remember'));

        //check login status
        if($login_status)
        {
            //save the login session
            $login_session_repository->saveLogin($this->authentication_service);
            return response()->redirectToIntended(config('app.admin_route').'/dashboard');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors($this->authentication_service->getLoginMsg());
        }
    }

    function logout(LoginSessionRepositoryInterface $login_repository)
    {
        //do logout
        $this->authentication_service->logout();
        //save logout action
        $login_repository->saveLogout();

        return response()->redirectTo(config('app.admin_route'));
    }
}
