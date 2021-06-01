<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="file")
 */
class File implements FileInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use DeletableTrait;
    use NameableTrait;

    use OrderAwareTrait {
        getOrder as public getOriginalOrder;
        hasOrder as public hasOriginalOrder;
        setOrder as public setOriginalOrder;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Folder")
     * @ORM\JoinColumn(name="folder_id", nullable=true)
     */
    private ?FolderInterface $folder = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $path = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $colorCount = null;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $stitchCount = null;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $diameter = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Background")
     * @ORM\JoinColumn(name="background_id", nullable=true)
     */
    private ?BackgroundInterface $background = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $svg = null;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $bytes = null;
}