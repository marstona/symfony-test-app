<?php

declare(strict_types=1);

namespace App\Users\Domain\Repository;

use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Exception\EntityNotFoudException;
use App\Users\Domain\ValueObject\EmailValue;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

interface UserRepositoryInterface
{
    /**
     * @throws UniqueConstraintViolationException
     */
    public function add(User $user): void;

    /**
     * @throws EntityNotFoudException
     */
    public function findByEmail(EmailValue $email): User;

    /**
     * @throws EntityNotFoudException
     */
    public function findById(UlidValue $ulid): User;

    /**
     * @return array
     */
    public function getUsers(): array;

    /**
     * @param  User $user
     * @return void
     */
    public function remove(User $user): void;
}
