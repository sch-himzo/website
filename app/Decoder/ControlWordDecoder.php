<?php

declare(strict_types=1);

namespace App\Decoder;

class ControlWordDecoder implements ControlWordDecoderInterface
{
    public function decode(array $controlBytes, ?array $originalPosition = null): array
    {
        $positionDifference = $originalPosition ?? [0, 0];

        foreach(self::MOVEMENT_BYTE_MAP as $index => $values) {

            foreach ($values as $bitIndex => $value) {
                if ($controlBytes[$index][$bitIndex]) {
                    foreach ($positionDifference as $key => & $coordinate) {
                        $coordinate += $value[$key] / self::DECODE_FACTOR;
                    }
                }
            }

        }

        return $positionDifference;
    }
}
