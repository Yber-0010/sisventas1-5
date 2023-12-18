<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ArticuloCrearEvent;
use App\Listeners\ArticuloCrearListener;
use App\Events\ArticuloActualizadoEvent;
use App\Listeners\ArticuloActualizadoListener;
use App\Events\stockminEvent;
use App\Listeners\stockminListener;
use App\Events\VencimientoEvent;
use App\Listeners\VencimientoListener;

class EventServiceProvider extends ServiceProvider
{
    
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ArticuloCrearEvent::class => [
            ArticuloCrearListener::class,
        ],
        ArticuloActualizadoEvent::class => [
            ArticuloActualizadoListener::class,
        ],
        stockminEvent::class => [
            stockminListener::class,
        ],
        VencimientoEvent::class => [
            VencimientoListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
    
}
