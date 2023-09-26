<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Domain\ValueObject\PlainPasswordValue;
use DateTimeImmutable;
use DateTimeInterface;

class UserPasswordHistory implements UserPasswordHistoryInterface
{
    private UlidValue $id;

    private User $user;

    private string $password;

    private DateTimeInterface $createdAt;

    public function __construct(
        UlidValue $id,
        User $user,
        PlainPasswordValue $plainPassword,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->password = $passwordHasher->hash($plainPassword->toString(), $user->getEmail()->toString());
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): UlidValue
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
