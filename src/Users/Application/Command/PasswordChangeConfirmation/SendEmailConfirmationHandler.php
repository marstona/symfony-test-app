<?php

declare(strict_types=1);

namespace App\Users\Application\Command\PasswordChangeConfirmation;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Application\Service\PasswordChangeConfirmationService;

final class SendEmailConfirmationHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly PasswordChangeConfirmationService $confirmService
    ) {
    }

    public function __invoke(SendEmailConfirmationCommand $cmd): void
    {
        $this->confirmService->confirm($cmd->userDTO->email);
    }
}
