<?php

namespace App\Providers;

use App\Events\OutgoingLetterCreated;
use App\Events\SentCreated;
use App\Listeners\CreateIncomingLetter;
use App\Listeners\InboxListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SentCreated::class => [
            InboxListener::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // parent::boot();
    }
}
