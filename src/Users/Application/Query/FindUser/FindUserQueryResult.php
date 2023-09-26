<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUser;

use App\Shared\Application\Query\QueryResultInterface;
use App\Users\Application\DTO\UserDTO;

readonly class FindUserQueryResult implements QueryResultInterface
{
    public function __construct(
        public UserDTO $user
    ) {
    }
}
