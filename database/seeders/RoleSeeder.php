<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $roles = [
        ["id"=> 1, "name"=> "Super Admin", "guard_name"=> "web"],
        ["id"=> 2, "name"=> "Admin", "guard_name"=> "web"],
        ["id"=> 3, "name"=> "Company", "guard_name"=> "web"],
        ["id"=> 4, "name"=> "User", "guard_name"=> "web"],
        ["id"=> 5, "name"=> "Vendor", "guard_name"=> "web"],
    ];

    foreach ($roles as $role) {
        Role::create([
            'id'=> $role['id'],
            'name' => $role['name'],
            'guard_name' => $role['guard_name'],
        ]);
    }
    }
}
