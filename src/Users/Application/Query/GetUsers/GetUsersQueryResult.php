<?php

declare(strict_types=1);

namespace App\Users\Application\Query\GetUsers;

use App\Shared\Application\Query\QueryResultInterface;
use App\Users\Application\DTO\UserDTO;

readonly class GetUsersQueryResult implements QueryResultInterface
{
    /**
     * @param UserDTO[] $users
     */
    public function __construct(
        public array $users = []
    ) {
    }
}
