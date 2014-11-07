<?php

namespace SimpleBus\CommandEventBridge\CommandBus;

use SimpleBus\Command\Command;
use SimpleBus\Command\Bus\CommandBus;
use SimpleBus\Command\Bus\RemembersNext;
use SimpleBus\Event\Bus\EventBus;
use SimpleBus\Event\Provider\ProvidesEvents;

class DispatchesEvents implements CommandBus
{
    use RemembersNext;

    private $eventProvider;
    private $eventBus;

    public function __construct(ProvidesEvents $eventProvider, EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
        $this->eventProvider = $eventProvider;
    }

    public function handle(Command $command)
    {
        $this->next($command);

        foreach ($this->eventProvider->releaseEvents() as $event) {
            $this->eventBus->handle($event);
        }
    }
}
