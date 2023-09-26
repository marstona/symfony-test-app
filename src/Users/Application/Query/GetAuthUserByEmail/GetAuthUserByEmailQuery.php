<?php

declare(strict_types=1);

namespace App\Users\Application\Query\GetAuthUserByEmail;

use App\Shared\Application\Query\QueryInterface;
use App\Users\Domain\ValueObject\EmailValue;

final readonly class GetAuthUserByEmailQuery implements QueryInterface
{
    public function __construct(
        public EmailValue $email
    ) {
    }
}
