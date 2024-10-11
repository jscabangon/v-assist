<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::create([
            'username' => 'admin',
            'password' => bcrypt('12345678'),
            'usertype' => 'admin'
        ]);

        $admin->details()->create([
            'firstname' => 'System',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
        ]);
    }
}
