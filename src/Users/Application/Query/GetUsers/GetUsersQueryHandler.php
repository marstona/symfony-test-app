<?php

declare(strict_types=1);

namespace App\Users\Application\Query\GetUsers;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;

final class GetUsersQueryHandler implements QueryHandlerInterface
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @param  GetUsersQuery       $query
     * @return GetUsersQueryResult
     */
    public function __invoke(GetUsersQuery $query): GetUsersQueryResult
    {
        $users = $this->userRepository->getUsers();
        $result = array_map(
            fn ($user) => UserDTO::fromEntity($user),
            $users
        );

        return new GetUsersQueryResult($result);
    }
}
