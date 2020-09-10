<?php

declare(strict_types=1);

namespace App\Entities\Design;

use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;

class DesignGroup implements DesignGroupInterface
{
    use EntityTrait;
    use TimestampableTrait;
}
