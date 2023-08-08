<?php

namespace Database\Seeders;

use App\Models\Market\PaymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentStatus::create([
            'code'=>0,
            'name'=>'پرداخت نشده'
        ]);
        PaymentStatus::create([
            'code'=>1,
            'name'=>'پرداخت شده'
        ]);
        PaymentStatus::create([
            'code'=>2,
            'name'=>'باطل شده'
        ]);
        PaymentStatus::create([
            'code'=>3,
            'name'=>'برگشت داده شده '
        ]);
    }
}
