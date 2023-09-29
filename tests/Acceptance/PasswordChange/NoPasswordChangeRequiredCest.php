<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\PasswordChange;

use App\Users\Domain\Entity\User;
use Tests\Support\AcceptanceTester;

class NoPasswordChangeRequiredCest
{
    private const NEW_PASSWORD = '22@@wwWW';

    private const PASSWORD = '11!!qqQQ';

    private User $user;

    public function _before(AcceptanceTester $I)
    {
        $this->user = $I->userWithActivePasswordFixture(self::PASSWORD);
        $I->loginUser($this->user->getEmail()->toString(), self::PASSWORD);
    }

    public function noPasswordChangeRequired(AcceptanceTester $I)
    {
        $I->wantToTest('whether the user password change is not required after password change');

        $I->changePassword(self::NEW_PASSWORD);
        $I->loginUser($this->user->getEmail()->toString(), self::NEW_PASSWORD);

        $I->amOnPage('/account');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Account', 'h1');

        $I->amOnPage('/users');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Users', 'h1');

        $I->amOnPage('/users/import');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Import users', 'h1');
    }
}
