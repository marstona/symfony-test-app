<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Security;

use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Infrastructure\Repository\Doctrine\MysqlUserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class AuthUserProvider implements UserProviderInterface
{
    /**
     * @param MysqlUserRepository $userRepository
     */
    public function __construct(
        private readonly MysqlUserRepository $userRepository,
    ) {
    }

    /**
     * @param  string        $identifier
     * @return UserInterface
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $emailValue = EmailValue::fromString($identifier);
        $user = $this->userRepository->findByEmail($emailValue);
        $latestPassword = $user->getLatestPassword();

        return AuthUser::create(
            $user->getId()->toString(),
            $user->getEmail()->toString(),
            $latestPassword ? $latestPassword->getPassword() : '',
            $user->isPasswordChangeRequired(),
        );
    }

    /**
     * @param  UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    /**
     * @param  string $class
     * @return bool
     */
    public function supportsClass(string $class): bool
    {
        return $class === AuthUser::class;
    }
}
