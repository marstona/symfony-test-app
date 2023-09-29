<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Repository\Doctrine;

use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Exception\EntityNotFoudException;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\ValueObject\EmailValue;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NoResultException;

class MysqlUserRepository implements UserRepositoryInterface
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param  User $user
     * @return void
     */
    public function add(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param  EmailValue $email
     * @return User
     */
    public function findByEmail(EmailValue $email): User
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        try {
            $user = $qb->getQuery()->getOneOrNullResult();

            return $user ?? throw new NoResultException();
        } catch (ORMException $e) {
            throw new EntityNotFoudException($e->getMessage());
        }
    }

    /**
     * @param  UlidValue $ulid
     * @return User
     */
    public function findById(UlidValue $ulid): User
    {
        try {
            $user = $this->entityManager->find(User::class, $ulid);

            return $user ?? throw new NoResultException();
        } catch (NoResultException $e) {
            throw new EntityNotFoudException();
        }
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param  User $user
     * @return void
     */
    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
