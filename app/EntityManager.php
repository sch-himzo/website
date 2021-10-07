<?php

declare(strict_types=1);

namespace App;

use App\Event\DoctrineFlushEvent;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager as BaseEntityManager;

class EntityManager extends BaseEntityManager
{
    public function __construct(
        Connection $conn,
        Configuration $config,
        EventManager $eventManager
    ) {
        parent::__construct($conn, $config, $eventManager);
    }

    public function flush($entity = null)
    {
        DoctrineFlushEvent::dispatch();

        parent::flush($entity);
    }
}