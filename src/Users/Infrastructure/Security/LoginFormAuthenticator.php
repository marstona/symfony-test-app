<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Security;

use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\LogIn\LogInCommand;
use App\Users\Domain\Entity\UserInterface;
use App\Users\Domain\Exception\InvalidCredentialsException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    private const LOGIN = 'login';

    private const SUCCESS_REDIRECT = 'account_show_page';

    private const CHANGE_PASSWORD = 'change_password_page';

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function authenticate(Request $request): Passport
    {
        try {
            $credentials = $this->getCredentials($request);
            $username = $credentials['username'];
            $password = $credentials['password'];

            $loginCommand = new LogInCommand($username, $password);
            $this->commandBus->handle($loginCommand);

            return new SelfValidatingPassport(new UserBadge($username));
        } catch (InvalidCredentialsException|InvalidArgumentException $e) {
            throw new AuthenticationException($e->getMessage());
        }
    }

    private function getCredentials(Request $request): array
    {
        return [
            'username' => $request->request->get('_username'),
            'password' => $request->request->get('_password'),
        ];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        /**
         * @var UserInterface $user
         */
        $user = $token->getUser();
        if ($user->isPasswordChangeRequired()) {
            return new RedirectResponse($this->urlGenerator->generate(self::CHANGE_PASSWORD));
        }

        return new RedirectResponse($this->urlGenerator->generate(self::SUCCESS_REDIRECT));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN);
    }
}
