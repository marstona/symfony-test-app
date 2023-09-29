<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\PasswordChange;

use App\Users\Domain\Entity\User;
use Tests\Support\AcceptanceTester;

class PasswordChangeEmailNotificationCest
{
    private const NEW_PASSWORD = '22@@wwWW';

    private const PASSWORD = '11!!qqQQ';

    private User $user;

    public function _before(AcceptanceTester $I)
    {
        $this->user = $I->newUserFixture(self::PASSWORD);
        $I->loginUser($this->user->getEmail()->toString(), self::PASSWORD);
    }

    public function passwordChangeEmailNotification(AcceptanceTester $I): void
    {
        $I->wantToTest('whether the user received an e-mail notification about the password change');
        $I->resetEmails();

        $I->changePassword(self::NEW_PASSWORD);
        $I->loginUser($this->user->getEmail()->toString(), self::NEW_PASSWORD);
        $I->wait(1);
        $I->seeInLastEmail('Password changed');
    }
}
