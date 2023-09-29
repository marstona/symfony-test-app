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
    /**
     * @param UserRepositoryInterface $userRepository
     * @param EntityManagerInterface  $entityManager
     * @param UserFactory             $userFactory
     * @param EventBusInterface       $eventBus
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserFactory $userFactory,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    /**
     * @param  CreateUserCommand $command
     * @return void
     */
    public function __invoke(CreateUserCommand $command): void
    {
        $user = $this->userFactory->create(
            $command->id->toString(),
            $command->email->toString(),
            $command->password->toString()
        );

        try {
            $this->userRepository->add($user);
            $this->entityManager->flush();

            $userDTO = UserDTO::fromEntity($user);
            $this->eventBus->handle(
                new UserCreatedEvent($userDTO),
            );
        } catch (UniqueConstraintViolationException $e) {
            throw new EmailAlreadyExistsException('Email already exists');
        }
    }
}
