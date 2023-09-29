<?php

declare(strict_types=1);

namespace App\Users\Domain\Factory;

use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Domain\ValueObject\PlainPasswordValue;
use DateTimeInterface;

readonly class UserFactory
{
    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * @param  string                 $id
     * @param  string                 $email
     * @param  string                 $password
     * @param  bool                   $passwordChangeRequired
     * @param  DateTimeInterface|null $passwordCreatedAt
     * @return User
     */
    public function create(
        string $id,
        string $email,
        string $password,
        bool $passwordChangeRequired = true,
        DateTimeInterface $passwordCreatedAt = null
    ): User {
        $idValue = UlidValue::fromString($id);
        $emailValue = EmailValue::fromString($email);
        $passwordValue = PlainPasswordValue::fromString($password);

        $user = new User($idValue, $emailValue);
        $user->setPassword($passwordValue, $this->passwordHasher, $passwordCreatedAt);
        $user->setPasswordChangeRequired($passwordChangeRequired);

        return $user;
    }
}
