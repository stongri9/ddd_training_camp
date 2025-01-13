<?php

namespace App\Providers;

use App\Domains\Inquiry\IInquiryRepository;
use App\Repositories\Inquiry\InquiryRepository;
use App\Domains\Shift\IShiftRepository;
use App\Repositories\Shift\ShiftRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IInquiryRepository::class, InquiryRepository::class);
        $this->app->singleton(IShiftRepository::class, ShiftRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
