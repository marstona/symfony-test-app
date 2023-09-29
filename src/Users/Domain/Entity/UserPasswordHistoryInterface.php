<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\ValueObject\UlidValue;
use DateTimeInterface;

interface UserPasswordHistoryInterface
{
    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface;

    /**
     * @return UlidValue
     */
    public function getId(): UlidValue;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;
}
