<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Mailer;

use App\Shared\Application\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Mailer\MailerInterface as BaseMailer;
use Throwable;

final class SymfonyMailer implements MailerInterface
{
    /**
     * @param BaseMailer            $mailer
     * @param ContainerBagInterface $params
     */
    public function __construct(
        private readonly BaseMailer $mailer,
        private readonly ContainerBagInterface $params,
    ) {
    }

    /**
     * @throws MailerException
     */
    public function send(string $email, string $subject, string $template, array $context = []): void
    {
        try {
            $from = $this->params->get('mailer_sender');
            $message = (new TemplatedEmail())
                ->from($from)
                ->to($email)
                ->subject($subject)
                ->htmlTemplate($template)
                ->context($context);
            $this->mailer->send($message);
        } catch (Throwable $e) {
            throw new MailerException('Failed to send mail: ' . $e->getMessage(), 0, $e);
        }
    }
}
