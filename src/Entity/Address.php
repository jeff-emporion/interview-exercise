<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interfaces\EntityWithPersonInterface;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

use function sprintf;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address implements EntityWithPersonInterface
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
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="addresses", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=191)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=191)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=191, nullable=true)
     */
    private $city;

    public function __toString(): string
    {
        return sprintf('%s %s %s', $this->getAddress(), $this->getCity(), $this->getCountry());
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
