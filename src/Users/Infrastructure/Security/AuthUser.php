<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Security;

use App\Shared\Domain\Security\Role;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    private function __construct(
        private readonly string $id,
        private readonly string $email,
        private readonly string $hashedPassword,
        private readonly bool $passwordChangeRequired
    ) {
    }

    public static function create(string $id, string $email, string $hashedPassword, bool $passwordChangeRequired): self
    {
        return new self($id, $email, $hashedPassword, $passwordChangeRequired);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    public function getPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getRoles(): array
    {
        return [
            Role::ROLE_USER,
        ];
    }

    public function eraseCredentials(): void
    {
    }

    public function __toString(): string
    {
        return $this->getUserIdentifier();
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function isPasswordChangeRequired(): bool
    {
        return $this->passwordChangeRequired;
    }
}
