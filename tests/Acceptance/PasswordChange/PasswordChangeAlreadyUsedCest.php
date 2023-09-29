<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\PasswordChange;

use App\Users\Domain\Entity\User;
use Tests\Support\AcceptanceTester;

class PasswordChangeAlreadyUsedCest
{
    private const NEW_PASSWORD = '22@@wwWW';

    private const PASSWORD = '11!!qqQQ';

    private User $user;

    public function _before(AcceptanceTester $I)
    {
        $this->user = $I->userWithActivePasswordFixture(self::PASSWORD);
        $I->loginUser($this->user->getEmail()->toString(), self::PASSWORD);
    }

    public function passwordChangeAlreadyUsed(AcceptanceTester $I)
    {
        $I->wantTo('ensure that user cannot reuse a previously used password');
        $I->changePassword(self::NEW_PASSWORD);
        $I->see('Password changed successfully');

        $I->loginUser($this->user->getEmail()->toString(), self::NEW_PASSWORD);
        $I->changePassword(self::PASSWORD);
        $I->see('Password has already been used before');
    }
}
