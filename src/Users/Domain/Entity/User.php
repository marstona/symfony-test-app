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

    private DateTimeInterface $createdAt;

    private EmailValue $email;

    private UlidValue $id;

    private bool $passwordChangeRequired = true;

    /**
     * Therefore using this class in your model and elsewhere does not introduce a coupling to the ORM.
     * https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/association-mapping.html#initializing-collections
     *
     * @var Collection<int, UserPasswordHistory>
     */
    private Collection $passwordHistory;

    private ?DateTimeInterface $updatedAt = null;

    /**
     * @param UlidValue  $id
     * @param EmailValue $email
     */
    public function __construct(UlidValue $id, EmailValue $email)
    {
        $this->id = $id;
        $this->email = $email;
        $this->createdAt = new DateTimeImmutable();
        $this->passwordHistory = new ArrayCollection();
    }

    /**
     * @param  PlainPasswordValue          $plainPassword
     * @param  UserPasswordHasherInterface $passwordHasher
     * @return void
     */
    public function changePassword(PlainPasswordValue $plainPassword, UserPasswordHasherInterface $passwordHasher): void
    {
        $this->setPassword($plainPassword, $passwordHasher);
        $this->passwordChangeRequired = false;
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return EmailValue
     */
    public function getEmail(): EmailValue
    {
        return $this->email;
    }

    /**
     * @return UlidValue
     */
    public function getId(): UlidValue
    {
        return $this->id;
    }

    /**
     * @throws EntityNotFoudException
     */
    public function getLatestPassword(): UserPasswordHistoryInterface|false
    {
        $passwordHistory = $this->passwordHistory->first();
        if ($passwordHistory === false) {
            throw new EntityNotFoudException('You must reset your password');
        }

        return $passwordHistory;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     */
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
     * @param  PlainPasswordValue          $plainPassword
     * @param  UserPasswordHasherInterface $passwordHasher
     * @param  DateTimeInterface|null      $createdAt
     * @return void
     */
    public function setPassword(PlainPasswordValue $plainPassword, UserPasswordHasherInterface $passwordHasher, DateTimeInterface $createdAt = null): void
    {
        $id = UlidValue::fromString(Ulid::generate());
        $latestPassword = new UserPasswordHistory(
            $id,
            $this,
            $plainPassword,
            $passwordHasher,
            $createdAt
        );
        $this->passwordHistory->add($latestPassword);
    }

    /**
     * @param  bool $passwordChangeRequired
     * @return void
     */
    public function setPasswordChangeRequired(bool $passwordChangeRequired): void
    {
        $this->passwordChangeRequired = $passwordChangeRequired;
    }
}
