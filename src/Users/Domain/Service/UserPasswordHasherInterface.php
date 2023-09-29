<?php

declare(strict_types=1);

namespace App\Users\Domain\Service;

interface UserPasswordHasherInterface
{
    /**
     * @param  string $plainPassword
     * @param  string $salt
     * @return string
     */
    public function hash(string $plainPassword, string $salt): string;

    /**
     * @param  string $hashedPassword
     * @param  string $plainPassword
     * @param  string $salt
     * @return bool
     */
    public function verify(string $hashedPassword, string $plainPassword, string $salt): bool;
}
