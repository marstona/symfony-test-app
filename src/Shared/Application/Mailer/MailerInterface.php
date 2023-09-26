<?php

declare(strict_types=1);

namespace App\Shared\Application\Mailer;

interface MailerInterface
{
    /**
     * @return mixed
     */
    public function send(string $email, string $subject, string $template);
}
