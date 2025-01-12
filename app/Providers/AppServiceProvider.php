<?php

namespace App\Providers;

use App\Domains\Inquiry\IInquiryRepository;
use App\Repositories\Inquiry\InquiryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IInquiryRepository::class, InquiryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
