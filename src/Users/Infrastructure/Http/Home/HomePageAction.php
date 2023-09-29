<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[AsController]
#[Route('/', name: 'home_page', methods: ['GET'])]
class HomePageAction extends AbstractController
{
    /**
     * @param  AuthenticationUtils $authUtils
     * @return Response
     */
    public function __invoke(AuthenticationUtils $authUtils): Response
    {
        return $this->render('home/home_page.html.twig');
    }
}
