<?php

declare(strict_types=1);

namespace App\Users\Application\Command\LogIn;

use App\Shared\Application\Command\CommandInterface;

final readonly class LogInCommand implements CommandInterface
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
