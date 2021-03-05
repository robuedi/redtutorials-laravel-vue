<?php

namespace App\Http\Controllers\auth;

use App\Http\Requests\client\RegisterRequest;
use App\Services\Authentication\AuthenticationServiceInterface;
use App\Services\Authentication\Facade\AuthenticationFacadeInterface;
use Illuminate\Http\Request;

class RegisterController
{
    private AuthenticationServiceInterface $authentication_service;
    private AuthenticationFacadeInterface $authentication_facade;

    public function __construct(AuthenticationServiceInterface $authentication_service, AuthenticationFacadeInterface $authentication_facade)
    {
        $this->authentication_service = $authentication_service;
        $this->authentication_facade = $authentication_facade;
    }

    public function index(Request $request)
    {
        //check if register active
        $register = session()->get('register');

        //check if redirect back after register/sign-in
        if($request->get('return') === 'true')
        {
            session()->flash('return-back-to', url()->previous());
        }

        //check if user is logged in as client
        switch ($this->authentication_service->checkIfClient())
        {
            case 'yes':
                return response()->redirectToIntended();

            case 'no':
                return view('auth.register-login', ['register' => $register]);

            case 'inactivated':
                return view('auth.register-login', ['register' => true])->withErrors(['Account not activated.']);
        }
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->authentication_facade->register('client',
            [
                'first_name'    =>  $request->get('first_name'),
                'last_name'     =>  $request->get('last_name'),
                'email'         =>  $request->get('email'),
                'password'      =>  $request->get('password'),
            ], $request->root().'/activate-account/');

        //show feedback
        if($response['status'])
        {
            return view('static-pages.msg', [
                'title' => 'Email Confirmation',
                'msg'   => ' We just <strong>sent an email</strong> to confirm your email address, you can check your <strong>Inbox.</strong> <br/><br/>Please take notice that sometimes it may take <strong>couple of minutes for the email to arrive</strong>.'
            ]);
        }

        return view('static-pages.msg', [
            'title' => 'Something went wrong...',
            'msg'   => 'Please try again later or contact the support team.'
        ]);
    }

}
