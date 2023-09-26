<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;

final class FindUserByEmailHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(FindUserByEmailQuery $query): FindUserByEmailResult
    {
        $user = $this->userRepository->findByEmail($query->email);
        $userDTO = UserDTO::fromEntity($user);

        return new FindUserByEmailResult($userDTO);
    }
}
