<?php

declare(strict_types = 1);

namespace App\Enums;

final class Roles
{
    public const ADMIN = 'Admin';
    public const EDITOR = 'Editor';
    public const STAFF = 'Staff';
    public const STUDENT = 'Student';

    public const ADMIN_ID = 1;
    public const EDITOR_ID = 2;
    public const STAFF_ID = 3;
    public const STUDENT_ID = 4;
}
