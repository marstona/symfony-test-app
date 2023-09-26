<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Account;

use App\Users\Infrastructure\Forms\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/account/change-password', name: 'change_password_page', methods: ['GET'])]
class ChangePasswordGetAction extends AbstractController
{
    public function __invoke(Security $security): Response
    {
        $form = $this->createForm(ChangePasswordType::class);

        return $this->render('account/change_password.html.twig', [
            'form' => $form,
        ]);
    }
}
