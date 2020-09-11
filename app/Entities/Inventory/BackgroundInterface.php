<?php

declare(strict_types=1);

namespace App\Entities\Inventory;

use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;

interface BackgroundInterface extends
    EntityInterface,
    TimestampableInterface
{

}
