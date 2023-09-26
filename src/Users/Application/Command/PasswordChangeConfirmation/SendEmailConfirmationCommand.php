<?php

declare(strict_types=1);

namespace App\Users\Application\Command\PasswordChangeConfirmation;

use App\Shared\Application\Command\AsyncCommandInterface;
use App\Users\Application\DTO\UserDTO;

readonly class SendEmailConfirmationCommand implements AsyncCommandInterface
{
    public function __construct(
        public UserDTO $userDTO
    ) {
    }
}
