<?php

declare(strict_types=1);

namespace App\Users\Application\Service;

use App\Shared\Application\Mailer\MailerInterface;
use App\Users\Domain\Service\PasswordChangeConfirmationInterface;

final class PasswordChangeConfirmationService implements PasswordChangeConfirmationInterface
{
    private const CONFIRM_SUBJECT = 'Password change confirmation email';

    private const CONFIRM_TEMPLATE = 'emails/password_change_confirmation.html.twig';

    public function __construct(
        private readonly MailerInterface $mailer
    ) {
    }

    public function confirm(string $email): void
    {
        $this->mailer->send(
            $email,
            self::CONFIRM_SUBJECT,
            self::CONFIRM_TEMPLATE
        );
    }
}
