<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $rnd = rand(0, 1);
        $admin = User::create([
            'avatar' => 1,
            'email'=>'m.ebrahimi.talo1990@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '09387589696',
            'national_code'=>2080110403,
            'first_name' => 'مهرداد',
            'last_name' => 'ابراهیمی',
            'activation' => 1,
            'activation_date' => now(),
            'status' => 1,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $admin->assignRole(Role::where('name', '=', Roles::SuperAdmin)->first());



    }
}
