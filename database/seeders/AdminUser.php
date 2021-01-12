<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name'=>'customer',
            'description'=>'Customer role'
        ]);

        $role = Role::create([
            'name'=>'admin',
            'description'=>'Admin role'
        ]);

        $user = User::create([
            'role_id'=>$role->id,
            'email'=>'admin@admin.com',
            'password'=>bcrypt('12345'),
        ]);

        Profile::create([
            'user_id'=>$user->id,
        ]);
    }
}
