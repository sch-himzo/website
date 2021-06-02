<?php

declare(strict_types=1);

namespace App\Entity;

interface OrderInterface extends
    ResourceInterface,
    TimestampableInterface,
    NameableInterface,
    UserAwareInterface,
    DeletableInterface,
    CommentableInterface
{
    public const PAYMENT_TYPE_INTERNAL = 'internal';
    public const PAYMENT_TYPE_EXTERNAL = 'external';

    public const STATE_DRAFT = 'draft';
    public const STATE_PLACED = 'placed';
    public const STATE_APPROVED = 'approved';
    public const STATE_DESIGNED = 'designed';
    public const STATE_EMBROIDERED = 'embroidered';
    public const STATE_PAID = 'paid';
    public const STATE_DONE = 'archived';
}