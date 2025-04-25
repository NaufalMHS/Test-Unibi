<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan Seeder.
     */
    public function run(): void
    {
       

        // Ambil role yang sudah dibuat
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Jika role belum ada, jalankan RoleSeeder
        if (!$adminRole || !$userRole) {
            $this->call(RoleSeeder::class);
            $adminRole = Role::where('name', 'admin')->first();
            $userRole = Role::where('name', 'user')->first();
        }

        $user1 = User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);
        $user1->assignRole($userRole);

        $user2 = User::create([
            'name' => 'user2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password123'),
        ]);
        $user2->assignRole($userRole);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole($adminRole);

        
        
    }
}
