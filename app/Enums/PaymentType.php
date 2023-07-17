<?php
namespace App\Enums;

enum PaymentType:string {
    const OfflinePayment ="App\Models\Market\OfflinePayment" ;
    const OnlinePayment = "App\Models\Market\OnlinePayment";
    const CashPayment ="App\Models\Market\CashPayment";
    const ALL=[
        self::OfflinePayment,
        self::OnlinePayment,
        self::CashPayment,
    ];
}
