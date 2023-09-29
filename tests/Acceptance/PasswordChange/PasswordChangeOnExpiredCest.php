<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\PasswordChange;

use App\Users\Domain\Entity\User;
use Tests\Support\AcceptanceTester;

class PasswordChangeOnExpiredCest
{
    private const PASSWORD = '11!!qqQQ';

    private User $user;

    public function _before(AcceptanceTester $I)
    {
        $this->user = $I->userWithExpiredPasswordFixture(self::PASSWORD);
        $I->loginUser($this->user->getEmail()->toString(), self::PASSWORD);
    }

    public function passwordChangeOnExpired(AcceptanceTester $I)
    {
        $I->wantToTest('whether the user password change is required because password expiration');

        $I->amOnPage('/account');
        $I->seeCurrentUrlEquals('/account/change-password');
        $I->see('Change password', 'h1');

        $I->amOnPage('/users');
        $I->seeCurrentUrlEquals('/account/change-password');
        $I->see('Change password', 'h1');

        $I->amOnPage('/users/import');
        $I->seeCurrentUrlEquals('/account/change-password');
        $I->see('Change password', 'h1');
    }
}
