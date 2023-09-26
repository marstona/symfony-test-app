<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/account', name: 'account_show_page', methods: ['GET'])]
class AccountShowGetAction extends AbstractController
{
    public function __invoke(Security $security): Response
    {
        return $this->render('account/show.html.twig', [
            'user' => $security->getUser(),
        ]);
    }
}
