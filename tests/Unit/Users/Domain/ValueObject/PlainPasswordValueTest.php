<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\Domain\ValueObject;

use App\Users\Domain\Exception\PasswordTooWeakException;
use App\Users\Domain\ValueObject\PlainPasswordValue;
use Codeception\Test\Unit;

class PlainPasswordValueTest extends Unit
{
    public function testPasswordTooShort(): void
    {
        $this->expectException(PasswordTooWeakException::class);
        $this->expectExceptionMessage('Minimum password length is 8');

        $plainPassword = 'ABcd12$'; // Password length is 7

        PlainPasswordValue::fromString($plainPassword);
    }

    public function testPasswordMissingCapitalLetters(): void
    {
        $this->expectException(PasswordTooWeakException::class);
        $this->expectExceptionMessage('Minimum number of capital letters is 2');

        $plainPassword = 'abcde12#$'; // No capital letters

        PlainPasswordValue::fromString($plainPassword);
    }

    public function testPasswordMissingLowercaseLetters(): void
    {
        $this->expectException(PasswordTooWeakException::class);
        $this->expectExceptionMessage('Minimum number of lowercase letters is 2');

        $plainPassword = 'ABCDE12#$'; // No lowercase letters

        PlainPasswordValue::fromString($plainPassword);
    }

    public function testPasswordMissingDigits(): void
    {
        $this->expectException(PasswordTooWeakException::class);
        $this->expectExceptionMessage('Minimum number of digits is 2');

        $plainPassword = 'AbcdEF#$'; // No digits

        PlainPasswordValue::fromString($plainPassword);
    }

    public function testPasswordMissingSpecialCharacters(): void
    {
        $this->expectException(PasswordTooWeakException::class);
        $this->expectExceptionMessage('Minimum number of special characters is 2');

        $plainPassword = 'ABcd1234'; // No special characters

        PlainPasswordValue::fromString($plainPassword);
    }

    public function testValidPlainPassword(): void
    {
        $plainPassword = 'ABcd12#$';

        $password = PlainPasswordValue::fromString($plainPassword);

        $this->assertEquals($plainPassword, $password->toString());
    }
}
