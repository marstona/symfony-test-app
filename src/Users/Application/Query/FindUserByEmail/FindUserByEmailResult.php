<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryResultInterface;
use App\Users\Application\DTO\UserDTO;

readonly class FindUserByEmailResult implements QueryResultInterface
{
    /**
     * @param UserDTO $user
     */
    public function __construct(
        public UserDTO $user,
    ) {
    }
}
