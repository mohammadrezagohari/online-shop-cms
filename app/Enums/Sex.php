<?php
namespace App\Enums;

enum Sex:string {
    const Men = "men";
    const Women = "women";
    const Undefined = "Undefined";
    const ALL=[
        self::Women,
        self::Men,
        self::Undefined,
    ];
}
