<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // create 'User' role 
        Role::create(['name' => 'User']);
        
        // creating admin role
        Role::create(['name' => 'Admin']);
    }
}