<?php

declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use App\Users\Domain\Exception\InvalidEmailAddressFormatException;
use Stringable;
use const FILTER_VALIDATE_EMAIL;

final readonly class EmailValue implements Stringable
{
    /**
     * @param string $email
     */
    private function __construct(
        private string $email,
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }

    /**
     * @param  string $email
     * @return self
     */
    public static function fromString(string $email): self
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddressFormatException();
        }

        return new self($email);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->__toString();
    }
}
