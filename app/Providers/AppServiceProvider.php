<?php

namespace App\Providers;

use App\Contracts\AuthServiceContract;
use App\Contracts\Notification\NotificationServiceContract;
use App\Contracts\User\UserRepositoryContract;
use App\Contracts\User\UserServiceContract;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(AuthServiceContract::class, AuthService::class);
        $this->app->bind(NotificationServiceContract::class, NotificationService::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
