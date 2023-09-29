<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Users;

use App\Shared\Application\Query\QueryBusInterface;
use App\Users\Application\Query\GetUsers\GetUsersQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/users', name: 'users_page', methods: ['GET'])]
class UsersListGetAction extends AbstractController
{
    /**
     * @param QueryBusInterface $queryBus
     */
    public function __construct(
        private readonly QueryBusInterface $queryBus
    ) {
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $queryResult = $this->queryBus->ask(new GetUsersQuery());
        return $this->render('users/users_list.html.twig', [
            'users' => $queryResult->users,
        ]);
    }
}
