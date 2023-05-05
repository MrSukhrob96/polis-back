<?php

namespace App\Providers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\Interfaces\JWTServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\ServiceProvider;


/**
 * Services
 */
use App\Services\JWTService;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(JWTServiceInterface::class, JWTService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
