<?php

declare(strict_types=1);

namespace App\Users\Application\DTO;

use App\Users\Domain\Entity\User;
use Serializable;

class UserDTO implements Serializable
{
    /**
     * @param string $id
     * @param string $email
     */
    public function __construct(
        public string $id,
        public string $email,
    ) {
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }

    /**
     * @param  array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->id = (string) $data['id'];
        $this->email = (string) $data['email'];
    }

    /**
     * @param  User $user
     * @return self
     */
    public static function fromEntity(User $user): self
    {
        return new self($user->getId()->toString(), $user->getEmail()->toString());
    }

    /**
     * @return string|null
     */
    public function serialize(): ?string
    {
        return serialize([
            'id' => $this->id,
            'email' => $this->email,
        ]);
    }

    /**
     * @param  string $data
     * @return void
     */
    public function unserialize(string $data): void
    {
        $data = unserialize($data, [
            'allowed_classes' => false,
        ]);
        $this->id = (string) $data['id'];
        $this->email = (string) $data['email'];
    }
}
