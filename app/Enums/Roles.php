<?php

namespace App\Enums;

enum Roles: string
{
    const SuperAdmin='super-admin';
    const Admin = 'admin';
    const User = 'user';

    const SuperLevel = [
        self::SuperAdmin

    ];

    const ALL = [
        self::SuperAdmin,
        self::Admin,
        self::User,

    ];
}
