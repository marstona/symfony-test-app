<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

use App\Shared\Domain\Event\EventInterface;

interface EventBusInterface
{
    /**
     * @param  EventInterface $event
     * @return void
     */
    public function handle(EventInterface $event): void;
}
