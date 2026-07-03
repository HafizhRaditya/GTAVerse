<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
        ];
    }

    /**
     * Hanya user dengan flag is_admin yang boleh mengakses panel Filament (/admin).
     * Metode ini akan dipanggil oleh Filament jika terinstal.
     */
    public function canAccessPanel($panel): bool
    {
        return $this->is_admin;
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
