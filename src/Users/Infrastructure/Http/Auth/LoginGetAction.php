<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[AsController]
#[Route('/login', name: 'login_page', methods: ['GET'])]
class LoginGetAction extends AbstractController
{
    /**
     * @param  AuthenticationUtils $authUtils
     * @return Response
     */
    public function __invoke(AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();
        if ($error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('auth/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
        ]);
    }
}
