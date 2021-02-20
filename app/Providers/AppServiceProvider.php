<?php

namespace App\Providers;

use App\Repositories\LoginSessionRepository;
use App\Repositories\LoginSessionRepositoryInterface;
use App\Services\Authentication\AuthenticationService;
use App\Services\Authentication\AuthenticationServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(AuthenticationServiceInterface::class, AuthenticationService::class);
        app()->singleton(LoginSessionRepositoryInterface::class, LoginSessionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
