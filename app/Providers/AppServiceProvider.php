<?php

namespace app\Providers;

use app\Domains\DayOffRequest\IDayOffRequestRepository;
use app\Domains\Inquiry\IInquiryRepository;
use app\Domains\Shift\IShiftRepository;
use app\Domains\User\IUserRepository;
use app\Repositories\DayOffRequest\DayOffRequestRepository;
use app\Repositories\Inquiry\InquiryRepository;
use app\Repositories\Shift\ShiftRepository;
use app\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use app\Domains\ShiftPublishEvent\IShiftPublishEventRepository;
use app\Repositories\ShiftPublishEvent\ShiftPublishEventRepository;

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
        $this->app->singleton(IShiftPublishEventRepository::class, ShiftPublishEventRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
