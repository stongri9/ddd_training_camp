<?php

namespace app\Providers;

use app\Domains\Inquiry\IInquiryRepository;
use app\Domains\Shift\IShiftRepository;
use app\Repositories\Inquiry\InquiryRepository;
use app\Repositories\Shift\ShiftRepository;
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
