<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embedded
 */
trait AuthenticatableTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $rememberToken = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $password = null;

    public function getAuthIdentifierName(): string
    {
        return self::AUTHENTICATION_IDENTIFIER;
    }

    public function getAuthIdentifier(): ?int
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPassword()
    {
        return $this->{self::AUTHENTICATION_PASSWORD};
    }

    public function getRememberToken(): string
    {
        return $this->{self::AUTHENTICATION_REMEMBER_TOKEN};
    }

    /** @param string $value */
    public function setRememberToken($value): void
    {
        $this->{self::AUTHENTICATION_REMEMBER_TOKEN} = $value;
    }

    public function getRememberTokenName(): string
    {
        return self::AUTHENTICATION_REMEMBER_TOKEN;
    }
}