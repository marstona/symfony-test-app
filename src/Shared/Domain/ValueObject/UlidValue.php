<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Users\Domain\Exception\InvalidUlidFormatException;
use Stringable;

final readonly class UlidValue implements Stringable
{
    private function __construct(
        private string $ulid
    ) {
    }

    public static function fromString(string $ulid): self
    {
        if (26 !== \strlen($ulid)) {
            throw new InvalidUlidFormatException();
        }
        if (26 !== strspn($ulid, '0123456789ABCDEFGHJKMNPQRSTVWXYZabcdefghjkmnpqrstvwxyz')) {
            throw new InvalidUlidFormatException();
        }
        if ($ulid[0] > '7') {
            throw new InvalidUlidFormatException();
        }

        return new self($ulid);
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return $this->ulid;
    }
}
