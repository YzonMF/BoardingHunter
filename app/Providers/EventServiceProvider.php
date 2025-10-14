<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
<<<<<<< HEAD
     * The event listener mappings for the application.
     *
     * @var array
=======
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
<<<<<<< HEAD
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
=======
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
}
