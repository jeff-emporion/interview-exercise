<?php declare(strict_types = 1);

namespace App\Serializer;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;

class EntityNormalizer extends ObjectNormalizer
{
    public function __construct(
        protected readonly EntityManagerInterface $em,
        ?ClassMetadataFactoryInterface $classMetadataFactory = null,
        ?NameConverterInterface $nameConverter = null,
        ?PropertyAccessorInterface $propertyAccessor = null,
        ?PropertyTypeExtractorInterface $propertyTypeExtractor = null
    ) {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyAccessor, $propertyTypeExtractor);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null): bool
    {
        return str_starts_with($type, 'App\\Entity\\') && is_numeric($data);
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = [])
    {
        //var_dump($type, $data, $context);die;
        return $this->em->find($type, $data);
    }
}
