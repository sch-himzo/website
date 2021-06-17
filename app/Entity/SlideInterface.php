<?php

declare(strict_types=1);

namespace App\Entity;

interface SlideInterface extends
    ResourceInterface,
    NameableInterface,
    TimestampableInterface
{
    public function getImagePath(): ?string;

    public function setImagePath(?string $imagePath): void;

    public function getMessage(): ?string;

    public function setMessage(?string $message): void;

    public function getNumber(): ?int;

    public function setNumber(?int $number): void;
}