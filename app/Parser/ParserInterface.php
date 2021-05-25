<?php

declare(strict_types=1);

namespace App\Parser;

use App\Entity\DSTInterface;
use App\Models\Design as DesignContainer;

interface ParserInterface
{
    public const UPLOADED_DESIGN_STORAGE_PATH = 'app/images/uploads/designs/';

    public const HEXADECIMAL_BINARY_MAP = [
        '0' => '0000',
        '1' => '0001',
        '2' => '0010',
        '3' => '0011',
        '4' => '0100',
        '5' => '0101',
        '6' => '0110',
        '7' => '0111',
        '8' => '1000',
        '9' => '1001',
        'a' => '1010',
        'b' => '1011',
        'c' => '1100',
        'd' => '1101',
        'e' => '1110',
        'f' => '1111',
    ];

    public function parse(DesignContainer $design): ?DSTInterface;
}
