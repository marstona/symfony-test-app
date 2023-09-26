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

    public function remove(User $user): void;

    /**
     * @throws EntityNotFoudException
     */
    public function findById(UlidValue $ulid): User;

    /**
     * @throws EntityNotFoudException
     */
    public function findByEmail(EmailValue $email): User;

    public function getUsers(): array;
}
