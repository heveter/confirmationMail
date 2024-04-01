<?php

namespace App\Providers;

use App\Contracts\AuthServiceContract;
use App\Contracts\Notification\NotificationServiceContract;
use App\Contracts\UserRepositoryContract;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\NotificationService;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
