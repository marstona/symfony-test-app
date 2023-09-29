<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Mailer;

use App\Shared\Application\Mailer\MailerExceptionInterface;
use Exception;

class MailerException extends Exception implements MailerExceptionInterface
{
}
