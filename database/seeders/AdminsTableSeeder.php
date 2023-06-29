<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('admins')->insert([
        //     'name' => "Admin",
        //     'email' => 'admin@admin.com',
        //     'password' => '$2y$10$aD3BqE2OCi45gTzCtMiqD.d0gUTMlGY4Y7Hyx6cFfPVrkYDDMX39O', // Admin@123
        //     'email_verified_at' => '2022-08-01 18:28:05'
        //     ]);

            $user = Admin::create([
                'name' => "Admin",
                'email' => 'admin@admin.com',
                'password' => '$2y$10$aD3BqE2OCi45gTzCtMiqD.d0gUTMlGY4Y7Hyx6cFfPVrkYDDMX39O', // Admin@123
                'email_verified_at' => '2022-08-01 18:28:05'
            ]);
          
            // $role = Role::create(['name' => 'Admin']);
            // Create a manager role for users authenticating with the admin guard:
            $role = Role::create(['guard_name' => 'admin', 'name' => 'Admin']);
           
            $permissions = Permission::pluck('id','id')->all();
         
            $role->syncPermissions($permissions);
           
            $user->assignRole([$role->id]);
    }
}
