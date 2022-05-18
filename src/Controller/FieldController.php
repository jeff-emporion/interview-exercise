<?php declare(strict_types=1);

namespace App\Controller;

use App\Attribute\Delete;
use App\Attribute\Update;
use App\Attribute\View;
use App\Entity\Field;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FieldController extends Controller
{
    #[Route('/field/{type}', methods: ['POST'], format: 'json')]
    public function create(Request $request, string $type = 'generic'): JsonResponse
    {
        return $this->createEntity(
            $request,
            Field::DISCRIMINATOR_MAP[$type] ?? throw new RuntimeException("Unknown type: $type")
        );
    }

    #[Route('/field/{id}', methods: ['PUT', 'PATCH'], format: 'json')]
    public function update(Request $request, Field $field): JsonResponse
    {
        return $this->updateEntity($request, $field);
    }

    #[Route('/field/{id}', methods: ['GET'], format: 'json')]
    public function view(Field $field): JsonResponse
    {
        return $this->viewEntity($field);
    }

    #[Route('/field/{id}', methods: ['DELETE'], format: 'json')]
    public function delete(Field $field): JsonResponse
    {
        return $this->deleteEntity($field);
    }
}
