<?php

namespace App\Http\Controllers;

use App\Services\Authentication\AuthenticationHelperInterface;

class UserProfileController extends Controller
{
    private AuthenticationHelperInterface $authentication_helper;

    public function __construct(AuthenticationHelperInterface $authentication_helper)
    {
        $this->authentication_helper = $authentication_helper;
    }

    public function index()
    {
        return view('profile.index', [
            'user' => $this->authentication_helper->getUserLogged()
        ]);
    }
}
