<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="temporary_user")
 */
class TemporaryUser implements TemporaryUserInterface
{
    use ResourceTrait;
    use NameableTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $email = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}