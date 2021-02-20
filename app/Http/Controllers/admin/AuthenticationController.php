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
//                UIMessage::set('danger', 'Account not activated.');
                return view('_admin.authentication.login');
        }
    }

    public function doLogin(LoginRequest $request, LoginSessionRepositoryInterface $login_session_repository)
    {
        $this->authentication_service->doLogin($request->get('email'),$request->get('password'),$request->get('remember'));

        if($this->authentication_service->getLoginStatus())
        {
            $login_session_repository->saveLogin();
            return response()->redirectToIntended(config('app.admin_route').'/dashboard');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors($this->authentication_service->getLoginMsg());
        }
    }

    function logout(LoginSessionRepositoryInterface $login_repository)
    {
        $this->authentication_service->logout();
        $login_repository->saveLogout();

        return response()->redirectTo(config('app.admin_route'));
    }
}
