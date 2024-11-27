<?php

namespace App\Providers;

use App\Services\Email\EmailService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\EmailServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
