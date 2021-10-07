<?php

declare(strict_types=1);

namespace App\Listener;

use App\Entity\ResourceInterface;
use App\Entity\TimestampableInterface;
use App\EntityManager;
use App\Event\DoctrineFlushEvent;
use Doctrine\Common\Collections\Collection;
use function Symfony\Component\String\b;

class DoctrineFlushListener implements EventListenerInterface
{
    private EntityManager $entityManager;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function handle(DoctrineFlushEvent $event): bool
    {
        $unitOfWork = $this->entityManager->getUnitOfWork();

        /** @var ResourceInterface $entityInsertion */
        foreach ($unitOfWork->getScheduledEntityInsertions() as $entityInsertion) {
            if ($entityInsertion instanceof TimestampableInterface) {
                $entityInsertion->setCreatedAtNow();
            }
        }

        /** @var ResourceInterface $entityUpdate */
        foreach ($unitOfWork->getScheduledEntityUpdates() as $entityUpdate) {
            if ($entityUpdate instanceof TimestampableInterface) {
                $entityUpdate->setUpdatedAtNow();
            }
        }

        /** @var Collection $collectionUpdate */
        foreach ($unitOfWork->getScheduledCollectionUpdates() as $collectionUpdate) {

            /** @var ResourceInterface $collectionItem */
            foreach ($collectionUpdate as $collectionItem) {
                if ($collectionItem instanceof TimestampableInterface) {
                    $collectionItem->setUpdatedAtNow();
                }
            }

        }

        return self::EVENT_SUCCESS;
    }
}