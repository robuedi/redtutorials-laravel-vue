<?php

namespace App\Http\Middleware;

use App\Services\Authentication\AuthenticationHelperInterface;
use Closure;
use Illuminate\Http\Request;

class AuthenticateClient
{
    private AuthenticationHelperInterface $authentication_helper;

    public function __construct(AuthenticationHelperInterface $authentication_helper)
    {
        $this->authentication_helper = $authentication_helper;
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
        switch ($this->authentication_helper->checkIfClient())
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
