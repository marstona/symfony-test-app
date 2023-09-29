<?php

declare(strict_types=1);

namespace App\Users\Domain\Service;

interface EmailNotificationInterface
{
    /**
     * @param  string $email
     * @return void
     */
    public function notify(string $email): void;
}
