<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Domain\Event\EventInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class MessengerEventBus implements EventBusInterface
{
    use MessageBusExceptionTrait;

    /**
     * @param MessageBusInterface $eventBus
     */
    public function __construct(
        private readonly MessageBusInterface $eventBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(EventInterface $event): void
    {
        try {
            $this->eventBus->dispatch($event);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
