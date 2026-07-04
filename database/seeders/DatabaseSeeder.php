<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default administrator account for the admin panel (/admin).
        // The password is only set on first creation so re-seeding
        // never resets a changed password.
        $admin = User::firstOrNew(['email' => 'admin@gtaverse.test']);

        if (! $admin->exists) {
            $admin->password = Hash::make('password');
        }

        $admin->name     = 'GTAVerse Administrator';
        $admin->is_admin = true;
        $admin->save();

        $this->call([
            CategorySeeder::class,
            GameSeeder::class,
            CharacterSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
