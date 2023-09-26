<?php

declare(strict_types=1);

namespace App\Users\Application\Command\ChangePassword;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Application\Event\PasswordChanged\UserPasswordChangedEvent;
use App\Users\Domain\Exception\PasswordAlreadyUsedException;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;

final class ChangePasswordHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EventBusInterface $eventBus
    ) {
    }

    public function __invoke(ChangePasswordCommand $cmd): void
    {
        $user = $this->userRepository->findByEmail($cmd->email);

        try {
            $user->changePassword($cmd->password, $this->passwordHasher);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $userDTO = UserDTO::fromEntity($user);
            $this->eventBus->handle(
                new UserPasswordChangedEvent($userDTO)
            );
        } catch (UniqueConstraintViolationException $e) {
            throw new PasswordAlreadyUsedException('Password has already been used before');
        }
    }
}
