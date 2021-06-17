<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataFactory;

abstract class AbstractEntityRepository extends EntityRepository
{
    protected EntityManagerInterface $entityManager;

    abstract protected function getClass(): string;

    public function __construct(
        EntityManagerInterface $entityManager,
        ClassMetadataFactory $classMetadataFactory
    ) {
        parent::__construct($entityManager, $classMetadataFactory->getMetadataFor($this->getClass()));

        $this->entityManager = $entityManager;
    }
}