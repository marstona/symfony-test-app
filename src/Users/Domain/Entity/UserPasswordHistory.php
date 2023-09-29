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
    private DateTimeInterface $createdAt;

    private UlidValue $id;

    private string $password;

    private User $user;

    /**
     * @param UlidValue                   $id
     * @param User                        $user
     * @param PlainPasswordValue          $plainPassword
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(
        UlidValue $id,
        User $user,
        PlainPasswordValue $plainPassword,
        UserPasswordHasherInterface $passwordHasher,
        DateTimeInterface $createdAt = null
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->password = $passwordHasher->hash($plainPassword->toString(), $user->getEmail()->toString());
        $this->createdAt = $createdAt === null ? new DateTimeImmutable() : $createdAt;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return UlidValue
     */
    public function getId(): UlidValue
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
