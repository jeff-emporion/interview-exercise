<?php declare(strict_types=1);

namespace App\Trait;

use DateTime;
use Doctrine\ORM\Mapping\PrePersist;

trait CreatedAt
{
    protected ?DateTime $createdAt = null;

    #[PrePersist]
    public function prePersistCreatedAt(): void
    {
        $this->createdAt ??= new DateTime();
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt ??= new DateTime();
    }
}
