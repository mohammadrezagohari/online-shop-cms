<?php

namespace App\Enums;

enum Roles: string
{
    //const SuperAdmin = 'super-admin';
    const Admin = 'admin';
    const User = 'user';
   // const Student = 'student';
    const SuperLevel = [
       // self::SuperAdmin,
        self::Admin,
    ];

    const ALL = [
       // self::SuperAdmin,
        self::Admin,
        self::User,
      //  self::Student,
    ];
}
