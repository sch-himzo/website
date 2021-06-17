<?php

declare(strict_types=1);

namespace App\Util;

class Roles
{
    public const ROLE_DEFAULT = 'default';
    public const ROLE_NEWBIE = 'newbie';
    public const ROLE_MEMBER = 'member';
    public const ROLE_BANKER = 'banker';
    public const ROLE_LEADER = 'leader';
    public const ROLE_ADMIN = 'admin';

    public const ROLE_MAP = [
        'Alap' => self::ROLE_DEFAULT,
        'Próbás' => self::ROLE_NEWBIE,
        'Tag' => self::ROLE_MEMBER,
        'Gazdaságis' => self::ROLE_BANKER,
        'Körbezető' => self::ROLE_LEADER,
        'Web Admin' => self::ROLE_ADMIN,
    ];
}