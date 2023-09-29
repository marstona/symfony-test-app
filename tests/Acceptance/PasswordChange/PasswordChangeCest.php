<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\PasswordChange;

use App\Users\Domain\Entity\User;
use Tests\Support\AcceptanceTester;

class PasswordChangeCest
{
    private const NEW_PASSWORD = '22@@wwWW';

    private const PASSWORD = '11!!qqQQ';

    private User $user;

    public function _before(AcceptanceTester $I)
    {
        $this->user = $I->newUserFixture(self::PASSWORD);
        $I->loginUser($this->user->getEmail()->toString(), self::PASSWORD);
    }

    public function passwordChange(AcceptanceTester $I)
    {
        $I->wantToTest('whether the user can change his password');
        $I->changePassword(self::NEW_PASSWORD);
        $I->see('Password changed successfully');
    }
}
