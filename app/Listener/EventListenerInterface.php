<?php

declare(strict_types=1);

namespace App\Listener;

interface EventListenerInterface
{
    public const EVENT_SUCCESS = true;
    public const EVENT_FAILURE = false;
}