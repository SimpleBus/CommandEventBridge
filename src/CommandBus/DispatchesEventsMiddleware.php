<?php

namespace SimpleBus\CommandEventBridge\CommandBus;

use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;
use SimpleBus\Event\Bus\EventBus;
use SimpleBus\Event\Provider\ProvidesEvents;
use SimpleBus\Message\Message;

class DispatchesEventsMiddleware implements MessageBusMiddleware
{
    private $eventProvider;
    private $eventBus;

    public function __construct(ProvidesEvents $eventProvider, EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
        $this->eventProvider = $eventProvider;
    }

    public function handle(Message $message, callable $next)
    {
        foreach ($this->eventProvider->releaseEvents() as $event) {
            $this->eventBus->handle($event);
        }

        $next($message);
    }
}
