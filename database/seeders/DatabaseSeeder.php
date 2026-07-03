<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun administrator default untuk panel Filament (/admin)
        User::updateOrCreate(
            ['email' => 'admin@gtaverse.test'],
            [
                'name'     => 'Administrator GTAVerse',
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
