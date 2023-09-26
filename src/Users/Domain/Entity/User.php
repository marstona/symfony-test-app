<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\ValueObject\UlidValue;
use App\Users\Domain\Exception\EntityNotFoudException;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Domain\ValueObject\EmailValue;
use App\Users\Domain\ValueObject\PlainPasswordValue;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Ulid;

class User implements UserInterface
{
    public const FORCE_PASSWORD_CHANGE_DAYS = 90;

    private UlidValue $id;

    private EmailValue $email;

    private DateTimeInterface $createdAt;

    private ?DateTimeInterface $updatedAt = null;

    private bool $passwordChangeRequired = true;

    /**
     * Therefore using this class in your model and elsewhere does not introduce a coupling to the ORM.
     * https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/association-mapping.html#initializing-collections
     *
     * @var Collection<int, UserPasswordHistory>
     */
    private Collection $passwordHistory;

    public function __construct(UlidValue $id, EmailValue $email)
    {
        $this->id = $id;
        $this->email = $email;
        $this->createdAt = new DateTimeImmutable();
        $this->passwordHistory = new ArrayCollection();
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $dateTime): void
    {
        $this->updatedAt = $dateTime;
    }

    public function getId(): UlidValue
    {
        return $this->id;
    }

    public function getEmail(): EmailValue
    {
        return $this->email;
    }

    public function isPasswordChangeRequired(): bool
    {
        if (! $this->passwordChangeRequired) {
            $latestPassword = $this->getLatestPassword();
            $interval = $latestPassword->getCreatedAt()->diff(new DateTime());
            $this->passwordChangeRequired = $interval->days > self::FORCE_PASSWORD_CHANGE_DAYS;
        }

        return $this->passwordChangeRequired;
    }

    /**
     * @throws EntityNotFoudException
     */
    public function getLatestPassword(): UserPasswordHistoryInterface|false
    {
        $passwordHistory = $this->passwordHistory->first();
        if (false === $passwordHistory) {
            throw new EntityNotFoudException('You must reset your password');
        }

        return $passwordHistory;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function changePassword(PlainPasswordValue $plainPassword, UserPasswordHasherInterface $passwordHasher): void
    {
        $this->setPassword($plainPassword, $passwordHasher);
        $this->passwordChangeRequired = false;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function setPassword(PlainPasswordValue $plainPassword, UserPasswordHasherInterface $passwordHasher): void
    {
        $id = UlidValue::fromString(Ulid::generate());
        $this->passwordHistory->add(new UserPasswordHistory(
            $id,
            $this,
            $plainPassword,
            $passwordHasher
        ));
    }
}
