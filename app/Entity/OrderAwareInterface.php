<?php

declare(strict_types=1);

namespace App\Entity;

interface OrderAwareInterface
{
    public function hasOrder(): bool;

    public function getOrder(): ?OrderInterface;

    public function setOrder(?OrderInterface $order): void;
}