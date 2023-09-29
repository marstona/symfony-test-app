<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/health-check', name: 'health_check', methods: ['GET'])]
class HealthCheckAction
{
    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return new JsonResponse([
            'status' => 'ok',
        ]);
    }
}
