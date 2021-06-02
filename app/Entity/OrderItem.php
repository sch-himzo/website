<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_item")
 */
class OrderItem implements OrderItemInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use DeletableTrait;
    use NameableTrait;
    use OrderAwareTrait;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $quantity = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $deadline = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $type = self::TYPE_BADGE;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $size = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $font = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $comment = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $state = self::STATE_DRAFT;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $originalDesign = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Folder")
     * @ORM\JoinColumn(name="folder_id", nullable=true)
     */
    private ?FolderInterface $folder = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\File")
     * @ORM\JoinColumn(name="dst_file_id", nullable=true)
     */
    private ?FileInterface $dstFile = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album")
     * @ORM\JoinColumn(name="test_album_id", nullable=true)
     */
    private ?AlbumInterface $testAlbum = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="marked_as_spam_by", nullable=true)
     */
    private ?UserInterface $markedAsSpamBy = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderImage", mappedBy="orderItem")
     */
    private Collection $images;

    /**
     * @ORM\OneTomany(targetEntity="App\Entity\Comment", mappedBy="order_item_id")
     */
    private Collection $comments;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function hasDeadline(): bool
    {
        return isset($this->deadline);
    }

    public function getDeadline(): ?DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?DateTimeInterface $deadline): void
    {
        $this->deadline = $deadline;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type ?? self::TYPE_BADGE;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): void
    {
        $this->size = $size;
    }

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function setFont(?string $font): void
    {
        $this->font = $font;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state ?? self::STATE_DRAFT;
    }

    public function isOriginalDesign(): bool
    {
        return $this->originalDesign;
    }

    public function setOriginalDesign(bool $originalDesign): void
    {
        $this->originalDesign = $originalDesign;
    }

    public function hasFolder(): bool
    {
        return isset($this->folder);
    }

    public function getFolder(): ?FolderInterface
    {
        return $this->folder;
    }

    public function setFolder(?FolderInterface $folder): void
    {
        $this->folder = $folder;
    }

    public function hasDstFile(): bool
    {
        return isset($this->dstFile);
    }

    public function getDstFile(): ?FileInterface
    {
        return $this->dstFile;
    }

    public function setDstFile(?FileInterface $dstFile): void
    {
        $this->dstFile = $dstFile;
    }

    public function hasTestAlbum(): bool
    {
        return isset($this->testAlbum);
    }

    public function getTestAlbum(): ?AlbumInterface
    {
        return $this->testAlbum;
    }

    public function setTestAlbum(?AlbumInterface $testAlbum): void
    {
        $this->testAlbum = $testAlbum;
    }

    public function isMarkedAsSpam(): bool
    {
        return isset($this->markedAsSpamBy);
    }

    public function getMarkedAsSpamBy(): ?UserInterface
    {
        return $this->markedAsSpamBy;
    }

    public function setMarkedAsSpamBy(?UserInterface $markedAsSpamBy): void
    {
        $this->markedAsSpamBy = $markedAsSpamBy;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function hasImage(OrderImageInterface $orderImage): bool
    {
        return $this->images->contains($orderImage);
    }

    public function addImage(OrderImageInterface $orderImage): void
    {
        if (!$this->hasImage($orderImage)) {
            $this->images->add($orderImage);
            $orderImage->setOrderItem($this);
        }
    }

    public function removeImage(OrderImageInterface $orderImage): void
    {
        if ($this->hasImage($orderImage)) {
            $this->images->removeElement($orderImage);
            $orderImage->setOrderItem(null);
        }
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function hasComment(CommentInterface $comment): bool
    {
        return $this->comments->contains($comment);
    }

    public function addComment(CommentInterface $comment): void
    {
        if (!$this->hasComment($comment)) {
            $this->comments->add($comment);
            $comment->setCommentable($this);
        }
    }

    public function removeComment(CommentInterface $comment): void
    {
        if ($this->hasComment($comment)) {
            $this->comments->removeElement($comment);
            $comment->setCommentable(null);
        }
    }
}