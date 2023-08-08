<?php

namespace Database\Seeders;

use App\Models\Market\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create([
            'code'=>0,
            'name'=>'در انتظار تایید '
        ]);
        OrderStatus::create([
            'code'=>1,
            'name'=>'تایید نشده'
        ]);
        OrderStatus::create([
            'code'=>2,
            'name'=>'تایید شده'
        ]);
        OrderStatus::create([
            'code'=>3,
            'name'=>'باطل شده'
        ]);
        OrderStatus::create([
            'code'=>4,
            'name'=>'مرجوع شده'
        ]);
        OrderStatus::create([
            'code'=>4,
            'name'=>'بررسی نشده'
        ]);
    }
}
