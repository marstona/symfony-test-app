<?php

declare(strict_types=1);

namespace App\Users\Application\Query\GetAuthUserByEmail;

use App\Shared\Application\Query\QueryResultInterface;
use App\Users\Application\DTO\UserDTO;

readonly class GetAuthUserByEmailResult implements QueryResultInterface
{
    public function __construct(
        public UserDTO $user
    ) {
    }
}
