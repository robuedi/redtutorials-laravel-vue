<?php

namespace App\Http\Controllers;

use App\Services\Authentication\AuthenticationServiceInterface;

class UserProfileController extends Controller
{
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(AuthenticationServiceInterface $authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    public function index()
    {
        return view('profile.index', [
            'user' => $this->authentication_service->getUserLogged()
        ]);
    }
}
