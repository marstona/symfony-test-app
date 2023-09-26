<?php

declare(strict_types=1);

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Application\Event\UserCreated\UserCreatedEvent;
use App\Users\Domain\Exception\EmailAlreadyExistsException;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;

final class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserFactory $userFactory,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateUserCommand $cmd): void
    {
        $user = $this->userFactory->create($cmd->id, $cmd->email, $cmd->password);

        try {
            $this->userRepository->add($user);
            $this->entityManager->flush();

            $userDTO = UserDTO::fromEntity($user);
            $this->eventBus->handle(
                new UserCreatedEvent($userDTO)
            );
        } catch (UniqueConstraintViolationException $e) {
            throw new EmailAlreadyExistsException('Email already exists');
        }
    }
}
