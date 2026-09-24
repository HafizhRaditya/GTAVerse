<?php

namespace Tests;

use App\Models\Article;
use App\Models\Category;
use App\Models\Character;
use App\Models\Game;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    /** Kata sandi bawaan untuk seluruh akun uji. */
    public const SANDI = 'rahasia123';

    protected function admin(array $attributes = []): User
    {
        return User::create(array_merge([
            'name'     => 'Administrator Uji',
            'email'    => 'admin@gtaverse.test',
            'password' => Hash::make(self::SANDI),
            'is_admin' => true,
        ], $attributes));
    }

    protected function nonAdmin(array $attributes = []): User
    {
        return $this->admin(array_merge([
            'email'    => 'pembaca@gtaverse.test',
            'is_admin' => false,
        ], $attributes));
    }

    protected function game(array $attributes = []): Game
    {
        return Game::create(array_merge([
            'title'    => 'Grand Theft Auto VII',
            'universe' => 'HD',
            'status'   => 'upcoming',
        ], $attributes));
    }

    protected function category(array $attributes = []): Category
    {
        return Category::create(array_merge(['name' => 'News'], $attributes));
    }

    protected function character(array $attributes = []): Character
    {
        return Character::create(array_merge([
            'game_id' => $attributes['game_id'] ?? $this->game()->id,
            'name'    => 'Lucia Caminos',
        ], $attributes));
    }

    protected function article(array $attributes = []): Article
    {
        return Article::create(array_merge([
            'user_id'      => User::query()->value('id') ?? $this->admin()->id,
            'title'        => 'Artikel Uji GTAVerse',
            'body'         => '<p>Isi artikel uji.</p>',
            'status'       => 'published',
            'published_at' => now()->subDay(),
        ], $attributes));
    }

    protected function message(array $attributes = []): Message
    {
        return Message::create(array_merge([
            'name' => 'Budi',
            'body' => 'Saran dari pengunjung.',
        ], $attributes));
    }
}
