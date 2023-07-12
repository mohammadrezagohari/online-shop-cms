<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $json_file=File::get(database_path('data/cities.json'));
        $cities=json_decode($json_file);
        foreach($cities as $city){
            City::create([
                'name'=>$city->name,
                'slug'=>$city->slug,
                'province_id'=>$city->province_id
            ]);
        }
    }
}
