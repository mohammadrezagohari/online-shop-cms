<?php
namespace App\Enums;

enum MimeImages:string {
    const jpg = "image/jpeg";
    const png = "image/png";
    const svg = "image/svg+xml";
    const tif = "image/tiff";
    const ALL=[
        self::jpg,
        self::png,
        self::svg,
        self::tif,
    ];
}
