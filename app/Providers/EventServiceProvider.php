<?php

namespace App\Providers;

use App\Events\OutgoingLetterCreated;
use App\Listeners\CreateIncomingLetter;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OutgoingLetterCreated::class => [
            CreateIncomingLetter::class,
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
