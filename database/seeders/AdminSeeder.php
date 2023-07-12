<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $rnd = rand(0, 1);
        $admin = User::create([
            'sex' => 1,
            'avatar' => $rnd,
            'email_verified_at' => now(),
            'is_enable' => $rnd,
            'mobile' => '09387589696',
            'first_name' => 'مهرداد',
            'last_name' => 'ابراهیمی',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
     //   $admin->assignRole(Role::where('name', '=', Roles::Admin)->first());
    }
}
