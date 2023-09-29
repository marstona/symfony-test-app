<?php

declare(strict_types=1);

namespace App\Users\Application\Event\PasswordChanged;

use App\Shared\Domain\Event\EventInterface;
use App\Users\Application\DTO\UserDTO;

final readonly class UserPasswordChangedEvent implements EventInterface
{
    /**
     * @param UserDTO $userDTO
     */
    public function __construct(
        public UserDTO $userDTO,
    ) {
    }
}
