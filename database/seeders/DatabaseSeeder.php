<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

          //  ProvinceSeeder::class,
          //  CitySeeder::class,
            //RuleSeeder::class,
           // SuperAdminSeeder::class,
           // DeliveryStatusSeeder::class,
          //  OrderStatusSeeder::class,
           // PaymentStatusSeeder::class,
            PaymentTypeSeeder::class

        ]);
    }
}
