<?php

namespace App\Http\Middleware;

use App\Services\Authentication\AuthenticationServiceInterface;
use Closure;
use Illuminate\Http\Request;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, AuthenticationServiceInterface $authentication_service)
    {
        //check if user is logged in as admin
        switch ($authentication_service->checkIfAdmin())
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
