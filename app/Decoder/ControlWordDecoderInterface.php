<?php

declare(strict_types=1);

namespace App\Decoder;

interface ControlWordDecoderInterface
{
    public const DECODE_FACTOR = -2;

    public const POS_BYTE_1 = 0;
    public const POS_BYTE_2 = 1;
    public const POS_BYTE_3 = 2;

    public const MOVEMENT_BYTE_MAP = [
        self::POS_BYTE_1 => [
            0 => [0, 1],
            1 => [0, -1],
            2 => [0, 9],
            3 => [0, -9],
            4 => [9, 0],
            5 => [-9, 0],
            6 => [1, 0],
            7 => [-1, 0],
        ],
        self::POS_BYTE_2 => [
            0 => [0, 3],
            1 => [0, -3],
            2 => [0, 27],
            3 => [0, -27],
            4 => [27, 0],
            5 => [-27, 0],
            6 => [3, 0],
            7 => [-3, 0],
        ],
        self::POS_BYTE_3 => [
            2 => [0, 81],
            3 => [0, -81],
            4 => [81, 0],
            5 => [-81, 0],
        ]
    ];

    public function decode(array $controlBytes, ?array $originalPosition = null): array;
}
