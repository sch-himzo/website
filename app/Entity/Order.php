<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

class Order implements OrderInterface
{
    use ResourceTrait;
    use TimestampableTrait;
    use NameableTrait;
    use UserAwareTrait;
    use DeletableTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $comment = null;

    /**
     * @ORM\ManyToOne(targetEntity=App\Entity\User)
     * @ORM\JoinColumn(name=approved_by, nullable=true)
     */
    private ?UserInterface $approvedBy = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $paymentType = self::PAYMENT_TYPE_EXTERNAL;

    /**
     * @ORM\ManyToOne(targetEntity=App\Entity\TemporaryUser)
     * @ORM\JoinColumn(name=temp_user_id)
     */
    private ?TemporaryUserInterface $temporaryUser = null;

    /**
     * @ORM\Column(type="string")
     */
    private string $state = self::STATE_DRAFT;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $albumPublicity = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $joint = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $helpNeeded = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $deadline = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $estimatedCompletionDate = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $markedAsSpam = false;

    /**
     * @ORM\ManyToOne(targetEntity=App\Entity\User)
     * @ORM\JoinColumn(name="reported_by")
     * */
    private ?UserInterface $markedBy = null;

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getApprovedBy(): ?UserInterface
    {
        return $this->approvedBy;
    }

    public function setApprovedBy(?UserInterface $approvedBy): void
    {
        $this->approvedBy = $approvedBy;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function setPaymentType(?string $paymentType): void
    {
        $this->paymentType = $paymentType ?? self::PAYMENT_TYPE_EXTERNAL;
    }

    public function getTemporaryUser(): ?TemporaryUserInterface
    {
        return $this->temporaryUser;
    }

    public function setTemporaryUser(?TemporaryUserInterface $temporaryUser): void
    {
        $this->temporaryUser = $temporaryUser;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $status): void
    {
        $this->state = $status;
    }

    public function isAlbumPublicity(): bool
    {
        return $this->albumPublicity;
    }

    public function setAlbumPublicity(?bool $albumPublicity): void
    {
        $this->albumPublicity = $albumPublicity ?? false;
    }

    public function isJoint(): bool
    {
        return $this->joint;
    }

    public function setJoint(?bool $joint): void
    {
        $this->joint = $joint ?? false;
    }

    public function isHelpNeeded(): bool
    {
        return $this->helpNeeded;
    }

    public function setHelpNeeded(?bool $helpNeeded): void
    {
        $this->helpNeeded = $helpNeeded ?? false;
    }

    public function getDeadline(): ?DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?DateTimeInterface $deadline): void
    {
        $this->deadline = $deadline;
    }

    public function getEstimatedCompletionDate(): ?DateTimeInterface
    {
        return $this->estimatedCompletionDate;
    }

    public function setEstimatedCompletionDate(?DateTimeInterface $estimatedCompletionDate): void
    {
        $this->estimatedCompletionDate = $estimatedCompletionDate;
    }

    public function isMarkedAsSpam(): bool
    {
        return $this->markedAsSpam;
    }

    public function setMarkedAsSpam(?bool $markedAsSpam): void
    {
        $this->markedAsSpam = $markedAsSpam ?? false;
    }

    public function getMarkedBy(): ?UserInterface
    {
        return $this->markedBy;
    }

    public function setMarkedBy(?UserInterface $markedBy): void
    {
        $this->markedBy = $markedBy;
    }
}