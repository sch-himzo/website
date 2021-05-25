<?php

declare(strict_types=1);

namespace App\Generator;

use App\Entity\DSTInterface;
use App\Models\Design;

interface GeneratorInterface
{
    public function generate(
        Design $design,
        DSTInterface $dst
    ): string;
}
