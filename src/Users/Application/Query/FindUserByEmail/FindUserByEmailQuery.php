<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryInterface;
use App\Users\Domain\ValueObject\EmailValue;

final readonly class FindUserByEmailQuery implements QueryInterface
{
    public function __construct(
        public EmailValue $email
    ) {
    }
}
