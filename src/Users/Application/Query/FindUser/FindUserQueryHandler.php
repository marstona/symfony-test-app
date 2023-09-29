<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUser;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;

final class FindUserQueryHandler implements QueryHandlerInterface
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * @param  FindUserQuery       $query
     * @return FindUserQueryResult
     */
    public function __invoke(FindUserQuery $query): FindUserQueryResult
    {
        $user = $this->userRepository->findById($query->id);
        $userDTO = UserDTO::fromEntity($user);

        return new FindUserQueryResult($userDTO);
    }
}
