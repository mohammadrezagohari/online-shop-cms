<?php

namespace Database\Seeders;

use App\Models\Market\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       PaymentType::create([
          'code'=>0,
          'name'=>'onlinePayment'
       ]);
        PaymentType::create([
            'code'=>0,
            'name'=>'offlinePayment'
        ]);
        PaymentType::create([
            'code'=>0,
            'name'=>'cashPayment'
        ]);
    }
}
