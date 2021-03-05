<?php

namespace App\Http\Middleware;

use App\Services\Authentication\AuthenticationServiceInterface;
use Closure;
use Illuminate\Http\Request;

class AuthenticateClient
{
    private AuthenticationServiceInterface $authentication_service;

    public function __construct(AuthenticationServiceInterface $authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //check if user is logged in as admin
        switch ($this->authentication_service->checkIfClient())
        {
            case 'yes':
                return $next($request);

            case 'no':
                return redirect('/register')->withErrors(['You must be logged in.']);

            case 'inactivated':
                return redirect('/register')->withErrors(['Account not activated.']);
        }
    }
}
