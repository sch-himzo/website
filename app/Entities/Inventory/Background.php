<?php

declare(strict_types=1);

namespace App\Entities\Inventory;

use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;

class Background implements BackgroundInterface
{
    use EntityTrait;
    use TimestampableTrait;
}
