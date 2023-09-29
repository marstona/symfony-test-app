<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Domain\ValueObject\PlainPasswordValue;

interface UserInterface
{
    /**
     * @param  PlainPasswordValue          $plainPassword
     * @param  UserPasswordHasherInterface $passwordHasher
     * @return void
     */
    public function changePassword(PlainPasswordValue $plainPassword, UserPasswordHasherInterface $passwordHasher): void;

    /**
     * @return EmailValue
     */
    public function getEmail(): EmailValue;

    /**
     * @return UlidValue
     */
    public function getId(): UlidValue;

    /**
     * @return UserPasswordHistoryInterface|false
     */
    public function getLatestPassword(): UserPasswordHistoryInterface|false;

    /**
     * @return bool
     */
    public function isPasswordChangeRequired(): bool;
}
