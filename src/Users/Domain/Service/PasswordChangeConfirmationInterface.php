<?php

declare(strict_types=1);

namespace App\Users\Domain\Service;

interface PasswordChangeConfirmationInterface
{
    public function confirm(string $email): void;
}
