<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity=AddressBook::class, inversedBy="addresses")
     */
    private $address_book;

    /**
     * @ORM\Column(type="date")
     */
    private $create_date;

    public function __construct()
    {
        $this->address_book = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|AddressBook[]
     */
    public function getAddressBook(): Collection
    {
        return $this->address_book;
    }

    public function addAddressBook(AddressBook $addressBook): self
    {
        if (!$this->address_book->contains($addressBook)) {
            $this->address_book[] = $addressBook;
        }

        return $this;
    }

    public function removeAddressBook(AddressBook $addressBook): self
    {
        $this->address_book->removeElement($addressBook);

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(\DateTimeInterface $create_Date): self
    {
        $this->create_date = $create_date;

        return $this;
    }
}
