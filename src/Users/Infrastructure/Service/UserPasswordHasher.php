<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Service;

use App\Users\Domain\Service\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\CheckPasswordLengthTrait;

class UserPasswordHasher implements UserPasswordHasherInterface
{
    use CheckPasswordLengthTrait;

    private const HASH_ALGO = 'sha512';

    public function verify(string $hashedPassword, string $plainPassword, string $salt): bool
    {
        return hash_equals($this->hash($plainPassword, $salt), $hashedPassword);
    }

    public function hash(string $plainPassword, string $salt): string
    {
        return hash(self::HASH_ALGO, $plainPassword . $salt);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return false;
    }
}
