<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Auth;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/logout', name: 'logout', methods: ['GET'])]
class LogoutGetAction
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        throw new RuntimeException('It should never have happened');
    }
}
