<?php

namespace SimpleBus\CommandEventBridge\CommandBus;

use SimpleBus\Command\Bus\Middleware\CommandBusMiddleware;
use SimpleBus\Command\Command;
use SimpleBus\Event\Bus\EventBus;
use SimpleBus\Event\Provider\ProvidesEvents;

class DispatchesEvents implements CommandBusMiddleware
{
    private $eventProvider;
    private $eventBus;

    public function __construct(ProvidesEvents $eventProvider, EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
        $this->eventProvider = $eventProvider;
    }

    public function handle(Command $command, callable $next)
    {
        $next($command);

        foreach ($this->eventProvider->releaseEvents() as $event) {
            $this->eventBus->handle($event);
        }
    }
}
