<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Security;

use App\Shared\Domain\Security\Role;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthUser implements PasswordAuthenticatedUserInterface, UserInterface
{
    /**
     * @param string $id
     * @param string $email
     * @param string $hashedPassword
     * @param bool   $passwordChangeRequired
     */
    private function __construct(
        private readonly string $id,
        private readonly string $email,
        private readonly string $hashedPassword,
        private readonly bool $passwordChangeRequired,
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @param  string $id
     * @param  string $email
     * @param  string $hashedPassword
     * @param  bool   $passwordChangeRequired
     * @return self
     */
    public static function create(string $id, string $email, string $hashedPassword, bool $passwordChangeRequired): self
    {
        return new self($id, $email, $hashedPassword, $passwordChangeRequired);
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->hashedPassword;
    }

    /**
     * @return array|string[]
     */
    public function getRoles(): array
    {
        return [
            Role::ROLE_USER,
        ];
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isPasswordChangeRequired(): bool
    {
        return $this->passwordChangeRequired;
    }
}
