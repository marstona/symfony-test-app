<?php

declare(strict_types=1);

namespace App\Users\Application\Service;

use App\Shared\Application\Mailer\MailerInterface;
use App\Users\Domain\Service\EmailNotificationInterface;

final class PasswordChangeNotificationService implements EmailNotificationInterface
{
    private const MESSAGE_SUBJECT = 'Password changed';

    private const MESSSAGE_TEMPLATE = 'emails/password_change_notification.html.twig';

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {
    }

    /**
     * @param  string $email
     * @return void
     */
    public function notify(string $email): void
    {
        $this->mailer->send(
            $email,
            self::MESSAGE_SUBJECT,
            self::MESSSAGE_TEMPLATE,
        );
    }
}
