<?php

namespace app\Providers;

use app\Domains\Inquiry\IInquiryRepository;
use app\Domains\Shift\IShiftRepository;
use app\Domains\User\IUserRepository;
use app\Domains\DayOffRequest\IDayOffRequestRepository;
use app\Repositories\Inquiry\InquiryRepository;
use app\Repositories\Shift\ShiftRepository;
use app\Repositories\User\UserRepository;
use app\Repositories\DayOffRequest\DayOffRequestRepository;
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
        $this->app->singleton(IUserRepository::class, UserRepository::class);
        $this->app->singleton(IDayOffRequestRepository::class, DayOffRequestRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
