<?php

declare(strict_types=1);

namespace App\Entity;

interface BackgroundInterface extends
    ResourceInterface,
    NameableInterface,
    TimestampableInterface
{
    public const COLOR_COMPONENT_RED = 'red';
    public const COLOR_COMPONENT_GREEN = 'green';
    public const COLOR_COMPONENT_BLUE = 'blue';

    public const COLOR_COMPONENT_MAP = [
        'Red' => self::COLOR_COMPONENT_RED,
        'Green' => self::COLOR_COMPONENT_GREEN,
        'Blue' => self::COLOR_COMPONENT_BLUE,
    ];
}