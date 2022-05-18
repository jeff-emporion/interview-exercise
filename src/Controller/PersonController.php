<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends Controller
{
    #[Route('/person', methods: ['POST'], format: 'json')]
    public function create(Request $request): JsonResponse
    {
        return $this->createEntity($request, Person::class);
    }

    #[Route('/person/{id}', methods: ['PUT', 'PATCH'], format: 'json')]
    public function update(Request $request, Person $person): JsonResponse
    {
        return $this->updateEntity($request, $person);
    }

    #[Route('/person/{id}', methods: ['GET'], format: 'json')]
    public function view(Person $person): JsonResponse
    {
        return $this->viewEntity($person);
    }

    #[Route('/person/{id}', methods: ['DELETE'], format: 'json')]
    public function delete(Person $person): JsonResponse
    {
        return $this->deleteEntity($person);
    }
}
