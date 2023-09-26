<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Service;

use App\Users\Domain\Entity\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PasswordChangeRequiredSubscriber implements EventSubscriberInterface
{
    private const CHANGE_PASSWORD_PAGE = 'change_password_page';

    private const CHANGE_PASSWORD_ACTION = 'change_password';

    private const EXCLUDED_ROUTES = [
        self::CHANGE_PASSWORD_PAGE,
        self::CHANGE_PASSWORD_ACTION,
    ];

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly Security $security,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            /**
             * @var UserInterface $user
             */
            $user = $this->security->getUser();
            if ($user->isPasswordChangeRequired() && ! in_array(
                $request->attributes->get('_route'),
                self::EXCLUDED_ROUTES,
                true
            )) {
                $this->entityManager->flush();
                $response = new RedirectResponse($this->urlGenerator->generate(self::CHANGE_PASSWORD_PAGE));
                $event->setResponse($response);
            }
        }
    }
}
