<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    #[Route('/contact', methods: ['POST'], format: 'json')]
    public function create(Request $request): JsonResponse
    {
        return $this->createEntity($request, Contact::class);
    }

    #[Route('/contact/{id}', methods: ['PUT', 'PATCH'], format: 'json')]
    public function update(Request $request, Contact $contact): JsonResponse
    {
        return $this->updateEntity($request, $contact);
    }

    #[Route('/contact/{id}', methods: ['GET'], format: 'json')]
    public function view(Contact $contact): JsonResponse
    {
        return $this->viewEntity($contact);
    }

    #[Route('/contact/{id}', methods: ['DELETE'], format: 'json')]
    public function delete(Contact $contact): JsonResponse
    {
        return $this->deleteEntity($contact);
    }
}
