<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainController
{
    #[Route('/', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'works' => true,
        ]);
    }
}
