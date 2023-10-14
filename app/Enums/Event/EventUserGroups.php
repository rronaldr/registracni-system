<?php

declare(strict_types=1);

namespace App\Enums\Event;

final class EventUserGroups
{
    public const EVERYONE = 1;
    public const CURRENT_STUDENTS = 2;
    public const GRADUATE = 3;
    public const STAFF = 4;
    public const ALL_STUDENTS = 5;
}
