<?php

declare(strict_types=1);

namespace App\Users\Application\Command\LogIn;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Application\Event\UserLoggedIn\UserLoggedInEvent;
use App\Users\Domain\Exception\DomainException;
use App\Users\Domain\Exception\InvalidCredentialsException;
use App\Users\Domain\Exception\PasswordVerificationException;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Domain\ValueObject\EmailValue;

final class LogInHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepositoryInterface $userRepository,
        private readonly EventBusInterface $eventBus
    ) {
    }

    public function __invoke(LogInCommand $cmd): void
    {
        try {
            $emailValue = EmailValue::fromString($cmd->email);
            $user = $this->userRepository->findByEmail($emailValue);
            $latestPassword = $user->getLatestPassword()->getPassword();

            if (! $this->passwordHasher->verify($latestPassword, $cmd->password, $emailValue->toString())) {
                throw new PasswordVerificationException();
            }

            $userDTO = UserDTO::fromEntity($user);
            $this->eventBus->handle(new UserLoggedInEvent($userDTO));
        } catch (DomainException $e) {
            throw new InvalidCredentialsException('Invalid credentials');
        }
    }
}
