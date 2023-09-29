<?php

declare(strict_types=1);

namespace App\Users\Domain\ValueObject;

use App\Users\Domain\Exception\PasswordTooWeakException;
use Stringable;

final readonly class PlainPasswordValue implements Stringable
{
    private const RULES = [
        [
            'pattern' => '/./',
            'value' => 8,
            'message' => 'Minimum password length',
        ],
        [
            'pattern' => '/[A-Z]/',
            'value' => 2,
            'message' => 'Minimum number of capital letters',
        ],
        [
            'pattern' => '/[a-z]/',
            'value' => 2,
            'message' => 'Minimum number of lowercase letters',
        ],
        [
            'pattern' => '/[0-9]/',
            'value' => 2,
            'message' => 'Minimum number of digits',
        ],
        [
            'pattern' => '/[^a-zA-Z0-9]/',
            'value' => 2,
            'message' => 'Minimum number of special characters',
        ],
    ];

    /**
     * @param string $plainPassword
     */
    private function __construct(
        private string $plainPassword,
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param  string $plainPassword
     * @return self
     */
    public static function fromString(string $plainPassword): self
    {
        foreach (self::RULES as $rule) {
            if (preg_match_all($rule['pattern'], $plainPassword) < $rule['value']) {
                throw new PasswordTooWeakException(sprintf('%s is %d', $rule['message'], $rule['value']));
            }
        }

        return new self($plainPassword);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->__toString();
    }
}
