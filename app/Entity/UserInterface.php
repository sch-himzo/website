<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserInterface extends
    ResourceInterface,
    Authenticatable,
    NameableInterface,
    TimestampableInterface,
    RoleAwareInterface
{
    public const AUTHENTICATION_IDENTIFIER = 'id';
    public const AUTHENTICATION_PASSWORD = 'password';
    public const AUTHENTICATION_REMEMBER_TOKEN = 'rememberToken';

    public function getEmail(): ?string;

    public function setEmail(?string $email): void;

    public function getInternalId(): ?string;

    public function setInternalId(?string $internalId): void;

    public function isInClub(): bool;

    public function setInClub(bool $inClub): void;

    public function isActivated(): bool;

    public function setActivated(bool $activated): void;

    public function getActivateToken(): ?string;

    public function setActivateToken(?string $activateToken): void;

    public function isAllowEmails(): bool;

    public function setAllowEmails(bool $allowEmails): void;

    public function isNotificationsDisabled(): bool;

    public function setNotificationsDisabled(bool $notificationsDisabled): void;

    public function isStickRole(): bool;

    public function setStickRole(bool $stickRole): void;

    public function getProjectFolder(): ?FolderInterface;

    public function setProjectFolder(?FolderInterface $projectFolder): void;
}