# CommandEventBridge

By [Matthias Noback](http://php-and-symfony.matthiasnoback.nl/)

## Installation

Using Composer:

    composer require simple-bus/command-event-bridge

## Usage

1. Create an event provider

    ```php
    use SimpleBus\Event\Provider\ProvidesEvents;

    class EventProvider implements ProvidesEvents
    {
        public function releaseEvents()
        {
            // return an array of SimpleBus\Event\Event objects
            return array(...);
        }
    }
    ```

2. Create a [command bus](https://github.com/SimpleBus/CommandBus) and an [event bus](https://github.com/SimpleBus/EventBus):

    ```php
    $commandBus = ...;
    $eventBus = ...;
    ```

3. Wrap the command bus inside a command bus which handles events provided by the event provider:

    ```php
    $eventProvider = new EventProvider();
    $eventDispatchingCommandBus = new DispatchesEventsMiddleware($eventProvider);

    $commandBus->handle(...);

    // events collected by the event provider will be passed to the event bus after the command has been handled
    ```
