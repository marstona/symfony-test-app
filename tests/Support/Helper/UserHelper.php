<?php

declare(strict_types=1);

namespace App\Tests\Support\Helper;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use Codeception\Module;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Uid\Ulid;

class UserHelper extends Module
{
    public function changePassword(string $password): void
    {
        $I = $this->getCrawler();
        $I->amOnPage('/account/change-password');
        $I->fillField('change_password[password][first]', $password);
        $I->fillField('change_password[password][second]', $password);
        $I->click('Save', 'form');
    }

    public function loginUser(string $email, string $password): void
    {
        $I = $this->getCrawler();
        $I->amOnPage('/login');
        $I->fillField('_username', $email);
        $I->fillField('_password', $password);
        $I->click('Login', 'form');
    }

    public function newUserFixture(string $password): User
    {
        $user = $this->getUserFactory()->create(
            Ulid::generate(),
            Factory::create()->email(),
            $password,
            true
        );

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    public function userWithActivePasswordFixture(string $password): User
    {
        $user = $this->getUserFactory()->create(
            Ulid::generate(),
            Factory::create()->email(),
            $password,
            false
        );

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    public function userWithExpiredPasswordFixture(string $password): User
    {
        $passwordDays = User::FORCE_PASSWORD_CHANGE_DAYS + 1;
        $expiredDate = new DateTime("-{$passwordDays} days");

        $user = $this->getUserFactory()->create(
            Ulid::generate(),
            Factory::create()->email(),
            $password,
            false,
            $expiredDate
        );

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    public function wait($seconds): void
    {
        sleep($seconds);
    }

    private function getCrawler()
    {
        return $this->getModule('PhpBrowser');
    }

    private function getEntityManager(): EntityManagerInterface
    {
        return $this->getModule('Doctrine2')->_getEntityManager();
    }

    private function getUserFactory(): UserFactory
    {
        return $this->getModule('Symfony')->grabService(UserFactory::class);
    }
}
