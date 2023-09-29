<?php

declare(strict_types=1);

namespace App\Users\Application\Event\PasswordChanged;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Event\EventHandlerInterface;
use App\Users\Application\Command\PasswordChangeNotitication\SendPasswordChangeNotificationCommand;

final class UserPasswordChangedHandler implements EventHandlerInterface
{
    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param  UserPasswordChangedEvent $event
     * @return void
     */
    public function __invoke(UserPasswordChangedEvent $event): void
    {
        $command = new SendPasswordChangeNotificationCommand($event->userDTO);
        $this->commandBus->handle($command);
    }
}
