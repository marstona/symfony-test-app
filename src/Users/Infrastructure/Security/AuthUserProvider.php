<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Security;

use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Infrastructure\Repository\Doctrine\MysqlUserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class AuthUserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly MysqlUserRepository $userRepository
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $emailValue = EmailValue::fromString($identifier);
        $user = $this->userRepository->findByEmail($emailValue);
        $latestPassword = $user->getLatestPassword();

        return AuthUser::create(
            $user->getId()->toString(),
            $user->getEmail()->toString(),
            $latestPassword ? $latestPassword->getPassword() : '',
            $user->isPasswordChangeRequired()
        );
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return AuthUser::class === $class;
    }
}
