<?php declare(strict_types=1);

namespace App\Entity;

use App\Trait\CreatedAt;
use App\Trait\UpdatedAt;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity]
#[HasLifecycleCallbacks]
class Person
{
    use CreatedAt;
    use UpdatedAt;

    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer', options: ['unsigned' => true])]
    #[Groups(['view'])]
    private ?int $id = null;

    #[NotBlank]
    #[Column(type: 'string', nullable: false, options: ['default' => ''])]
    #[Groups(['create', 'update', 'view'])]
    private string $name = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
