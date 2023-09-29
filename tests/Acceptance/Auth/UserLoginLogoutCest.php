<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Auth;

use App\Users\Domain\Entity\User;
use Tests\Support\AcceptanceTester;

class UserLoginLogoutCest
{
    private const PASSWORD = '11!!qqQQ';

    private User $user;

    public function _before(AcceptanceTester $I)
    {
        $this->user = $I->newUserFixture(self::PASSWORD);
    }

    public function userCanLogIn(AcceptanceTester $I)
    {
        $I->wantTo('log in user');
        $I->loginUser($this->user->getEmail()->toString(), self::PASSWORD);
        $I->see('Logout', 'a');
        $I->dontSee('Login', 'a');
    }

    public function userCanLogOut(AcceptanceTester $I)
    {
        $I->loginUser($this->user->getEmail()->toString(), self::PASSWORD);
        $I->wantTo('log out user');
        $I->click('Logout', 'a');
        $I->dontSee('Logout', 'a');
        $I->see('Login', 'a');
    }
}
