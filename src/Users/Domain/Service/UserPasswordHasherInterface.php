<?php

declare(strict_types=1);

namespace App\Users\Domain\Service;

interface UserPasswordHasherInterface
{
    public function hash(string $plainPassword, string $salt): string;

    public function verify(string $hashedPassword, string $plainPassword, string $salt): bool;
}
