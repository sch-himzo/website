<?php

declare(strict_types=1);

namespace App\Entities\User;

use App\Entities\Design\DesignGroupInterface;
use App\Entities\Gallery\ImageInterface;
use App\Entities\Order\OrderInterface;
use App\Traits\EntityInterface;
use App\Traits\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface UserInterface extends
    EntityInterface,
    TimestampableInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getRememberToken(): ?string;

    public function setRememberToken(?string $rememberToken): void;

    public function getRole(): RoleInterface;

    public function setRole(RoleInterface $role): void;

    public function getInternalId(): ?string;

    public function setInternalId(?string $internalId): void;

    public function getPassword(): ?string;

    public function setPassword(?string $password): void;

    public function isInClub(): bool;

    public function setInClub(bool $inClub): void;

    public function isActivated(): bool;

    public function setActivated(bool $activated): void;

    public function getActivateToken(): ?string;

    public function setActivateToken(?string $activateToken): void;

    public function getAllowEmails(): bool;

    public function setAllowEmails(bool $allowEmails): void;

    public function getEmailToken(): ?string;

    public function setEmailToken(?string $emailToken): void;

    public function areNotificationsDisabled(): bool;

    public function setNotificationsDisabled(bool $notificationsDisabled): void;

    public function isStickyRole(): bool;

    public function setStickyRole(bool $stickyRole): void;

    public function getProjectsDesignGroup(): ?DesignGroupInterface;

    public function setProjectsDesignGroup(?DesignGroupInterface $designGroup): void;

    public function getOrders(): ArrayCollection;

    public function hasOrder(OrderInterface $order): bool;

    public function hasOrders(): bool;

    public function addOrder(OrderInterface $order): void;

    public function removeOrder(OrderInterface $order): void;

    public function removeOrders(): void;

    public function getDesignGroups(): ArrayCollection;

    public function hasDesignGroup(DesignGroupInterface $designGroup): bool;

    public function hasDesignGroups(): bool;

    public function addDesignGroup(DesignGroupInterface $designGroup): void;

    public function removeDesignGroup(DesignGroupInterface $designGroup): void;

    public function removeDesignGroups(): void;

    public function getImages(): ArrayCollection;

    public function hasImage(ImageInterface $image): bool;

    public function hasImages(): bool;

    public function addImage(ImageInterface $image): void;

    public function removeImage(ImageInterface $image): void;

    public function removeImages(): void;
}
