<?php

declare(strict_types=1);

namespace App\Users\Domain\Factory;

use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Domain\ValueObject\PlainPasswordValue;

readonly class UserFactory
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function create(UlidValue $id, EmailValue $email, PlainPasswordValue $password): User
    {
        $user = new User($id, $email);
        $user->setPassword($password, $this->passwordHasher);

        return $user;
    }
}
