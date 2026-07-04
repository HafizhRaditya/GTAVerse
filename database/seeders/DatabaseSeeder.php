<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default administrator account for the admin panel (/admin)
        User::updateOrCreate(
            ['email' => 'admin@gtaverse.test'],
            [
                'name'     => 'GTAVerse Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $this->call([
            CategorySeeder::class,
            GameSeeder::class,
            CharacterSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
