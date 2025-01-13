<?php

namespace App\Providers;

use App\Domains\Inquiry\IInquiryRepository;
use App\Domains\User\IUserRepository;
use App\Repositories\Inquiry\InquiryRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IInquiryRepository::class, InquiryRepository::class);
        $this->app->singleton(IUserRepository::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
