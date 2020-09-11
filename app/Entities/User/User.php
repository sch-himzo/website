<?php

declare(strict_types=1);

namespace App\Entities\User;

use App\Entities\Design\DesignGroupInterface;
use App\Entities\Gallery\ImageInterface;
use App\Entities\Order\OrderInterface;
use App\Traits\EntityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;

class User implements UserInterface
{
    use EntityTrait;
    use TimestampableTrait;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var string */
    private $rememberToken;

    /** @var RoleInterface */
    private $role;

    /** @var string */
    private $internalId;

    /** @var string */
    private $password;

    /** @var bool */
    private $inClub;

    /** @var bool */
    private $activated;

    /** @var string */
    private $activateToken;

    /** @var bool */
    private $allowEmails;

    /** @var string */
    private $emailToken;

    /** @var bool */
    private $notificationsDisabled;

    /** @var bool */
    private $stickyRole;

    /** @var DesignGroupInterface|null */
    private $projectsDesignGroup;

    /** @var ArrayCollection|OrderInterface[] */
    private $orders;

    /** @var ArrayCollection|DesignGroupInterface[] */
    private $designGroups;

    /** @var ArrayCollection|ImageInterface[] */
    private $images;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken(?string $rememberToken): void
    {
        $this->rememberToken = $rememberToken;
    }

    public function getRole(): RoleInterface
    {
        return $this->role;
    }

    public function setRole(RoleInterface $role): void
    {
        $this->role = $role;
    }

    public function getInternalId(): ?string
    {
        return $this->internalId;
    }

    public function setInternalId(?string $internalId): void
    {
        $this->internalId = $internalId;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function isInClub(): bool
    {
        return $this->inClub;
    }

    public function setInClub(bool $inClub): void
    {
        $this->inClub = $inClub;
    }

    public function isActivated(): bool
    {
        return $this->activated;
    }

    public function setActivated(bool $activated): void
    {
        $this->activated = $activated;
    }

    public function getActivateToken(): ?string
    {
        return $this->activateToken;
    }

    public function setActivateToken(?string $activateToken): void
    {
        $this->activateToken = $activateToken;
    }

    public function getAllowEmails(): bool
    {
        return $this->allowEmails;
    }

    public function setAllowEmails(bool $allowEmails): void
    {
        $this->allowEmails = $allowEmails;
    }

    public function getEmailToken(): ?string
    {
        return $this->emailToken;
    }

    public function setEmailToken(?string $emailToken): void
    {
        $this->emailToken = $emailToken;
    }

    public function areNotificationsDisabled(): bool
    {
        return $this->notificationsDisabled;
    }

    public function setNotificationsDisabled(bool $notificationsDisabled): void
    {
        $this->notificationsDisabled = $notificationsDisabled;
    }

    public function isStickyRole(): bool
    {
        return $this->stickyRole;
    }

    public function setStickyRole(bool $stickyRole): void
    {
        $this->stickyRole = $stickyRole;
    }

    public function getProjectsDesignGroup(): ?DesignGroupInterface
    {
        return $this->projectsDesignGroup;
    }

    public function setProjectsDesignGroup(?DesignGroupInterface $designGroup): void
    {
        $this->projectsDesignGroup = $designGroup;
    }

    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    public function hasOrder(OrderInterface $order): bool
    {
        return $this->orders->contains($order);
    }

    public function hasOrders(): bool
    {
        return !$this->orders->isEmpty();
    }

    public function addOrder(OrderInterface $order): void
    {
        if(!$this->hasOrder($order)) {
            $this->orders->add($order);
        }
    }

    public function removeOrder(OrderInterface $order): void
    {
        if($this->hasOrder($order)) {
            $this->orders->removeElement($order);
        }
    }

    public function removeOrders(): void
    {
        $this->orders->clear();
    }

    public function getDesignGroups(): ArrayCollection
    {
        return $this->designGroups;
    }

    public function hasDesignGroup(DesignGroupInterface $designGroup): bool
    {
        return $this->designGroups->contains($designGroup);
    }

    public function hasDesignGroups(): bool
    {
        return !$this->designGroups->isEmpty();
    }

    public function addDesignGroup(DesignGroupInterface $designGroup): void
    {
        if(!$this->hasDesignGroup($designGroup)) {
            $this->designGroups->add($designGroup);
        }
    }

    public function removeDesignGroup(DesignGroupInterface $designGroup): void
    {
        if($this->hasDesignGroup($designGroup)) {
            $this->designGroups->removeElement($designGroup);
        }
    }

    public function removeDesignGroups(): void
    {
        $this->designGroups->clear();
    }

    public function getImages(): ArrayCollection
    {
        return $this->images;
    }

    public function hasImage(ImageInterface $image): bool
    {
        return $this->images->contains($image);
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function addImage(ImageInterface $image): void
    {
        if(!$this->hasImage($image)) {
            $this->images->add($image);
        }
    }

    public function removeImage(ImageInterface $image): void
    {
        if($this->hasImage($image)) {
            $this->images->removeElement($image);
        }
    }

    public function removeImages(): void
    {
        $this->images->clear();
    }
}
