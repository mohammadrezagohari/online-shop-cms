<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $json_file=File::get(database_path('data/provinces.json'));
        $provinces=json_decode($json_file);
        foreach($provinces as $province){
            Province::create([
                'name'=>$province->name,
                'slug'=>$province->slug
            ]);
        }
    }
}
