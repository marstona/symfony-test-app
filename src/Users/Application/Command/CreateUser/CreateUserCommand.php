<?php

declare(strict_types=1);

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\AsyncCommandInterface;
use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Domain\ValueObject\PlainPasswordValue;

final readonly class CreateUserCommand implements AsyncCommandInterface
{
    public EmailValue $email;

    public UlidValue $id;

    public PlainPasswordValue $password;

    /**
     * @param string $id
     * @param string $email
     * @param string $password
     */
    public function __construct(string $id, string $email, string $password)
    {
        $this->id = UlidValue::fromString($id);
        $this->email = EmailValue::fromString($email);
        $this->password = PlainPasswordValue::fromString($password);
    }
}
