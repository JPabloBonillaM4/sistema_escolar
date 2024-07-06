<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name'      => 'Super',
            'last_name' => 'Admin',
            'email'     => 'admin@erpinfo.com',
            'password'  => Hash::make('admin123456'),
        ]);
        $superadmin->assignRole('superadmin');
    }
}
