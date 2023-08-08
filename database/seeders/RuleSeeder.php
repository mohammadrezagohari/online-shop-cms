<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Validation\Rules\Enum;
use Spatie\Permission\Models\Role;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Role::create(['name'=>Roles::SuperAdmin]);
       Role::create(['name'=>Roles::Admin]);
       Role::create(['name'=>Roles::User]);
    }
}
