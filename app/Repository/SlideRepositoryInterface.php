<?php

declare(strict_types=1);

namespace App\Repository;

interface SlideRepositoryInterface
{
    public function findAll(): array;
}