<?php

declare(strict_types=1);

namespace App\Tests\Acceptance\Users;

use App\Users\Domain\Entity\User;
use Tests\Support\AcceptanceTester;

class UserImportCsvCest
{
    private const PASSWORD = '11!!qqQQ';

    private User $user;

    public function _before(AcceptanceTester $I)
    {
        $this->user = $I->userWithActivePasswordFixture(self::PASSWORD);
        $I->loginUser($this->user->getEmail()->toString(), self::PASSWORD);
    }

    public function invalidFileImport(AcceptanceTester $I)
    {
        $I->wantToTest('invalid file format handling');
        $I->amOnPage('/users/import');
        $I->attachFile('import_users[file]', 'users/invalid_format.csv');
        $I->click('Upload', 'form');
        $I->see('Please upload a valid CSV file');
    }

    public function validFileImport(AcceptanceTester $I)
    {
        $I->wantTo('import users from valid csv file');
        $I->amOnPage('/users/import');
        $I->attachFile('import_users[file]', 'users/valid.csv');
        $I->click('Upload', 'form');
        $I->see('File uploaded');
        $I->wait(2);
        $I->seeInDatabase('users', [
            'email' => 'user1@example.com',
        ]);
        $I->seeInDatabase('users', [
            'email' => 'user2@example.com',
        ]);
    }
}
