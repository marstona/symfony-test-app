<?php

declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use App\Users\Domain\Exception\InvalidEmailAddressFormatException;
use Stringable;

final readonly class EmailValue implements Stringable
{
    private function __construct(
        private string $email
    ) {
    }

    public static function fromString(string $email): self
    {
        if (! filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddressFormatException();
        }

        return new self($email);
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
