<?php

namespace App\Providers;

use App\Repositories\LoginSessionRepository;
use App\Repositories\LoginSessionRepositoryInterface;
use App\Services\Authentication\AuthenticationService;
use App\Services\Authentication\AuthenticationServiceInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function register()
    {
        app()->singleton(AuthenticationServiceInterface::class, AuthenticationService::class);
        app()->singleton(LoginSessionRepositoryInterface::class, LoginSessionRepository::class);
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
