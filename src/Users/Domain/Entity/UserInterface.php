<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Domain\ValueObject\PlainPasswordValue;

interface UserInterface
{
    public function getId(): UlidValue;

    public function getEmail(): EmailValue;

    public function getLatestPassword(): UserPasswordHistoryInterface|false;

    public function isPasswordChangeRequired(): bool;

    public function changePassword(PlainPasswordValue $plainPassword, UserPasswordHasherInterface $passwordHasher): void;
}
