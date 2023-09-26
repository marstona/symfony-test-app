<?php

declare(strict_types=1);

namespace App\Users\Application\DTO;

use App\Users\Domain\Entity\User;
use Serializable;

class UserDTO implements Serializable
{
    public function __construct(
        public string $id,
        public string $email
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self($user->getId()->toString(), $user->getEmail()->toString());
    }

    public function serialize(): ?string
    {
        return serialize([
            'id' => $this->id,
            'email' => $this->email,
        ]);
    }

    public function unserialize(string $data): void
    {
        $data = unserialize($data, [
            'allowed_classes' => false,
        ]);
        $this->id = (string) $data['id'];
        $this->email = (string) $data['email'];
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = (string) $data['id'];
        $this->email = (string) $data['email'];
    }
}
