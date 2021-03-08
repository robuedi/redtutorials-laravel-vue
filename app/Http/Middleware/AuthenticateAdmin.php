<?php

namespace App\Http\Middleware;

use App\Services\Authentication\AuthenticationHelperInterface;
use Closure;
use Illuminate\Http\Request;

class AuthenticateAdmin
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
        switch ($this->authentication_helper->checkIfAdmin())
        {
            case 'yes':
                return $next($request);

            case 'no':
                return redirect(config('app.admin_route'))->withErrors(['You must be logged in as admin.']);

            case 'inactivated':
                return redirect(config('app.admin_route'))->withErrors(['Account not activated.']);
        }
    }
}
