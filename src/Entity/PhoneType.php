<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PhoneTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use function sprintf;

/**
 * @ORM\Entity(repositoryClass=PhoneTypeRepository::class)
 */
class PhoneType
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
     * @var string
     *
     * @ORM\Column(type="string", length=191)
     */
    private $name;

    /**
     * @var Phone[]
     *
     * @ORM\OneToMany(targetEntity=Phone::class, mappedBy="type")
     */
    private $phones;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s: %s', $this->getId(), $this->getName());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Phone[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setType($this);
        }

        return $this;
    }

    public function removePhone(Phone $phone): self
    {
        if ($this->phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getType() === $this) {
                $phone->setType(null);
            }
        }

        return $this;
    }
}
