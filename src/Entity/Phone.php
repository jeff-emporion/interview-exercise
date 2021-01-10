<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\EntityWithPersonInterface;
use App\Repository\PhoneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use function sprintf;

/**
 * @ORM\Entity(repositoryClass=PhoneRepository::class)
 */
class Phone implements EntityWithPersonInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Person
     *
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="phones", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @var PhoneType
     *
     * @ORM\ManyToOne(targetEntity=PhoneType::class, inversedBy="phones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=191)
     */
    private $phoneNumber;

    public function __toString(): string
    {
        return sprintf('%s: %s', $this->getType()->getName(), $this->getPhoneNumber());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): EntityWithPersonInterface
    {
        $this->person = $person;

        return $this;
    }

    public function getType(): ?PhoneType
    {
        return $this->type;
    }

    public function setType(PhoneType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
