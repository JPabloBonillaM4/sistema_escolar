<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = Role::create(['name' => 'superadmin']); // Administrador
        $teacher = Role::create(['name' => 'teacher']); // Administrador
        $student = Role::create(['name' => 'student']); // Administrador
    }
}
