<?php

declare(strict_types=1);

namespace App\Users\Application\Command\PasswordChangeNotitication;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Application\Service\PasswordChangeNotificationService;

final class SendPasswordChangeNotiticationHandler implements CommandHandlerInterface
{
    /**
     * @param PasswordChangeNotificationService $confirmService
     */
    public function __construct(
        private readonly PasswordChangeNotificationService $confirmService,
    ) {
    }

    /**
     * @param  SendPasswordChangeNotificationCommand $command
     * @return void
     */
    public function __invoke(SendPasswordChangeNotificationCommand $command): void
    {
        $this->confirmService->notify($command->userDTO->email);
    }
}
