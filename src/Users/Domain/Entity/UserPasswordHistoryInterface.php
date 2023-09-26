<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\ValueObject\UlidValue;

interface UserPasswordHistoryInterface
{
    public function getId(): UlidValue;

    public function getUser(): UserInterface;

    public function getPassword(): string;

    public function getCreatedAt(): \DateTimeInterface;
}
