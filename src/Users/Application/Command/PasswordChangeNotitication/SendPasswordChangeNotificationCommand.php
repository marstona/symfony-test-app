<?php

declare(strict_types=1);

namespace App\Users\Application\Command\PasswordChangeNotitication;

use App\Shared\Application\Command\AsyncCommandInterface;
use App\Users\Application\DTO\UserDTO;

readonly class SendPasswordChangeNotificationCommand implements AsyncCommandInterface
{
    /**
     * @param UserDTO $userDTO
     */
    public function __construct(
        public UserDTO $userDTO,
    ) {
    }
}
