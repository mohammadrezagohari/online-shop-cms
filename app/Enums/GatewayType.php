<?php
namespace App\Enums;

enum GatewayType:string {
    const Zarinpal ="zarinpal";
    const Mellat= "Mellat";

    const ALL=[
        self::Zarinpal,
        self::Mellat,
    ];
}
