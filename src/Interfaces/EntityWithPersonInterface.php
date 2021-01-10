<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Entity\Person;

interface EntityWithPersonInterface
{
    public function getPerson(): ?Person;

    public function setPerson(Person $person): EntityWithPersonInterface;
}
