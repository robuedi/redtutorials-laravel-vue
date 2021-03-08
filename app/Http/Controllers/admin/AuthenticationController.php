<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\LoginRequest;
use App\Services\Authentication\AuthenticationHelperInterface;
use App\Services\Authentication\Facade\AuthenticationFacadeInterface;

class AuthenticationController extends Controller
{
    private AuthenticationHelperInterface $authentication_helper;
    private AuthenticationFacadeInterface $authentication_facade;

    public function __construct(AuthenticationHelperInterface $authentication_helper, AuthenticationFacadeInterface $authentication_facade)
    {
        $this->authentication_helper = $authentication_helper;
        $this->authentication_facade = $authentication_facade;
    }

    public function login()
    {
        //check if user is logged in as admin
        switch ($this->authentication_helper->checkIfAdmin())
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
        $login_status = $this->authentication_facade->login(['admin'], $request->get('email'),$request->get('password'),$request->get('remember'));

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
        if(!$this->authentication_facade->logout()){
            return response()->redirectTo(config('app.admin_route'))->withErrors(['Unable to logout.']);
        }

        return response()->redirectTo(config('app.admin_route'));
    }
}
