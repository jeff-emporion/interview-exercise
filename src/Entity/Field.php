<?php declare(strict_types=1);

namespace App\Entity;

use App\Enum\FieldType;
use App\Trait\CreatedAt;
use App\Trait\UpdatedAt;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity]
#[HasLifecycleCallbacks]
#[MappedSuperclass]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn('name', 'string', 32)]
#[DiscriminatorMap(Field::DISCRIMINATOR_MAP)]
class Field
{
    public const DISCRIMINATOR_MAP = [
        'generic'   => Field::class,
        'email'     => FieldEmail::class,
        'phone'     => FieldPhone::class,
        'note'      => FieldNote::class,
        'address'   => FieldAddress::class,
    ];

    use CreatedAt;
    use UpdatedAt;

    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups(['view'])]
    protected ?int $id = null;

    #[NotBlank]
    #[Column(type: 'string', length: 128, nullable: false, options: ['default' => ''])]
    #[Groups(['create', 'update', 'view'])]
    protected string $value = '';

    #[ManyToOne(Contact::class, inversedBy: 'fields')]
    #[JoinColumn(onDelete: 'CASCADE')]
    #[Groups(['create', 'view'])]
    protected ?Contact $contact = null;

    #[Column(length: 32, nullable: false, enumType: FieldType::class)]
    #[Groups(['create', 'update', 'view'])]
    protected FieldType $type = FieldType::home;

    #[Groups(['view'])]
    public function getName(): string
    {
        return array_search(static::class, self::DISCRIMINATOR_MAP, true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getType(): FieldType
    {
        return $this->type;
    }

    public function setType(FieldType $type): void
    {
        $this->type = $type;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): void
    {
        $this->contact = $contact;
    }
}
