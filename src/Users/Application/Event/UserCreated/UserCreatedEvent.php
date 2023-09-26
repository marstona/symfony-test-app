<?php

declare(strict_types=1);

namespace App\Users\Application\Event\UserCreated;

use App\Shared\Domain\Event\EventInterface;
use App\Users\Application\DTO\UserDTO;

final readonly class UserCreatedEvent implements EventInterface
{
    public function __construct(
        public UserDTO $userDTO
    ) {
    }
}
