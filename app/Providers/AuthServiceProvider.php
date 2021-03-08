<?php

namespace App\Providers;

use App\Repositories\LoginSessionRepositoryInterface;
use App\Repositories\Repositories\LoginSessionRepository;
use App\Services\Authentication\AuthenticationHelper;
use App\Services\Authentication\AuthenticationHelperInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        app()->singleton(AuthenticationHelperInterface::class, AuthenticationHelper::class);
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
