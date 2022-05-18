<?php declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class Controller extends AbstractController
{
    protected function createEntity(Request $request, string $class): JsonResponse
    {
        $entity = $this->container
            ->get(SerializerInterface::class)
            ->deserialize($request->getContent(), $class, 'json', [
                AbstractNormalizer::GROUPS => ['create']
            ]);
        $this->persist($entity);
        $this->flush();

        return $this->response($entity);
    }

    protected function updateEntity(Request $request, object $entity): JsonResponse
    {
        $entity = $this->container
            ->get(SerializerInterface::class)
            ->deserialize($request->getContent(), $entity::class, 'json', [
                AbstractNormalizer::OBJECT_TO_POPULATE => $entity,
                AbstractNormalizer::GROUPS => ['update']
            ]);
        $this->flush();

        return $this->response($entity);
    }

    protected function viewEntity(object $entity): JsonResponse
    {
        return $this->response($entity);
    }

    protected function deleteEntity(object $entity): JsonResponse
    {
        $this->remove($entity);
        $this->flush();

        return new JsonResponse();
    }

    protected function response(object $entity): JsonResponse
    {
        $json = $this->container
            ->get(SerializerInterface::class)
            ->serialize($entity, 'json', [
                AbstractNormalizer::GROUPS => 'view',
            ]);

        return new JsonResponse($json, json: true);
    }

    protected function persist(object $object): void
    {
        $this->container->get(EntityManagerInterface::class)->persist($object);
    }

    protected function remove(object $object): void
    {
        $this->container->get(EntityManagerInterface::class)->remove($object);
    }

    protected function flush(): void
    {
        $this->container->get(EntityManagerInterface::class)->flush();
    }

    public static function getSubscribedServices(): array
    {
        $services = parent::getSubscribedServices();
        $services[] = SerializerInterface::class;
        $services[] = EntityManagerInterface::class;

        return $services;
    }
}
