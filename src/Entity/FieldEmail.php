<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Validator\Constraints\Email;

#[Entity]
class FieldEmail extends Field
{
    #[Email]
    protected string $value = '';
}
