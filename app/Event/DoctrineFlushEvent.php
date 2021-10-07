<?php

declare(strict_types=1);

namespace App\Event;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use DateTimeInterface;
use DateTime;

class DoctrineFlushEvent implements EventInterface
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private DateTimeInterface $timestamp;

    public function __construct()
    {
        $this->timestamp = new DateTime();
    }
}