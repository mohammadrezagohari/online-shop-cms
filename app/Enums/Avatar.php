<?php
namespace App\Enums;

enum Avatar:int {
    const Men = 1;
    const Women = 0;
    const Undefined = 2;
    const ALL=[
        self::Women,
        self::Men,
        self::Undefined,
    ];
}
