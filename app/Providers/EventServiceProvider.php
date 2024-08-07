<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Listeners\PrepareGuestCartTransfer;
use App\Listeners\RecordAffiliateCommission;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Attempting::class => [
            PrepareGuestCartTransfer::class
        ],
        OrderPlaced::class => [
            RecordAffiliateCommission::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
