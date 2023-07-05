<?php

namespace App\Enums;

enum Roles: string
{
    const SuperAdmin = 'super-admin';
    const Admin = 'admin';
    const Teacher = 'teacher';
    const Student = 'student';
    const SuperLevel = [
        self::SuperAdmin,
        self::Admin,
    ];

    const ALL = [
        self::SuperAdmin,
        self::Admin,
        self::Teacher,
        self::Student,
    ];
}
