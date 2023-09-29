<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Users\Domain\Exception\InvalidUlidFormatException;
use Stringable;
use function strlen;

final readonly class UlidValue implements Stringable
{
    /**
     * @param string $ulid
     */
    private function __construct(
        private string $ulid,
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->ulid;
    }

    /**
     * @param  string $ulid
     * @return self
     */
    public static function fromString(string $ulid): self
    {
        if (strlen($ulid) !== 26) {
            throw new InvalidUlidFormatException();
        }
        if (strspn($ulid, '0123456789ABCDEFGHJKMNPQRSTVWXYZabcdefghjkmnpqrstvwxyz') !== 26) {
            throw new InvalidUlidFormatException();
        }
        if ($ulid[0] > '7') {
            throw new InvalidUlidFormatException();
        }

        return new self($ulid);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->__toString();
    }
}
