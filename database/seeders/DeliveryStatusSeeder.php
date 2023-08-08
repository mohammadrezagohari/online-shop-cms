<?php

namespace Database\Seeders;

use App\Models\Market\DeliveryStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryStatus::create([
            'code'=>0,
            'name'=>'ارسال نشده'
        ]);
        DeliveryStatus::create([
            'code'=>1,
            'name'=>'در حال ارسال'
        ]);
        DeliveryStatus::create([
            'code'=>2,
            'name'=>'ارسال شده'
        ]);
        DeliveryStatus::create([
            'code'=>3,
            'name'=>'تحویل شده'
        ]);
    }
}
