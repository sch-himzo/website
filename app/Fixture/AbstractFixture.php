<?php

declare(strict_types=1);

namespace App\Fixture;

abstract class AbstractFixture
{
    abstract public function run(): void;

    abstract public function getName(): string;
}