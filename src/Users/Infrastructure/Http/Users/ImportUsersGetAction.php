<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Users;

use App\Users\Infrastructure\Forms\ImportUsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/users/import', name: 'import_users_page', methods: ['GET'])]
class ImportUsersGetAction extends AbstractController
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $form = $this->createForm(ImportUsersType::class);

        return $this->render('users/import_users.html.twig', [
            'form' => $form,
        ]);
    }
}
