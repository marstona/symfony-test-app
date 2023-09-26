<?php

declare(strict_types=1);

namespace App\Users\Application\Command\ChangePassword;

use App\Shared\Application\Command\CommandInterface;
use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Domain\ValueObject\PlainPasswordValue;

final readonly class ChangePasswordCommand implements CommandInterface
{
    public EmailValue $email;

    public PlainPasswordValue $password;

    public function __construct(string $email, string $password)
    {
        $this->email = EmailValue::fromString($email);
        $this->password = PlainPasswordValue::fromString($password);
    }
}
