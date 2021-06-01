<?php

declare(strict_types=1);

namespace App\Entity;

interface FileInterface extends
    ResourceInterface,
    TimestampableInterface,
    DeletableInterface,
    NameableInterface,
    OrderAwareInterface
{

}