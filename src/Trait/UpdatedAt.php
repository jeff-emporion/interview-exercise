<?php declare(strict_types=1);

namespace App\Trait;

use DateTime;
use Doctrine\ORM\Mapping\PreFlush;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\Serializer\Annotation\Groups;

trait UpdatedAt
{
    protected ?DateTime $updatedAt = null;

    #[PreFlush]
    public function preFlushUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
