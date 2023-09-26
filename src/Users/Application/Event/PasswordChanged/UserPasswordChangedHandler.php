<?php

declare(strict_types=1);

namespace App\Users\Application\Event\PasswordChanged;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Event\EventHandlerInterface;
use App\Users\Application\Command\PasswordChangeConfirmation\SendEmailConfirmationCommand;

final class UserPasswordChangedHandler implements EventHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
    }

    public function __invoke(UserPasswordChangedEvent $event): void
    {
        $command = new SendEmailConfirmationCommand($event->userDTO);
        $this->commandBus->handle($command);
    }
}
