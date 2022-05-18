<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity]
class FieldAddress extends Field
{
    #[Column(type: 'string', length: 64, nullable: false, options: ['default' => ''])]
    #[Groups(['create', 'update', 'view'])]
    protected string $country = '';

    #[Column(type: 'string', length: 64, nullable: false, options: ['default' => ''])]
    #[Groups(['create', 'update', 'view'])]
    protected string $city = '';

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }
}
