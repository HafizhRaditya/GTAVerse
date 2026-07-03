<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasSlug;

    protected $fillable = [
        'title', 'slug', 'universe', 'release_date', 'platforms', 'setting',
        'tagline', 'description', 'cover_image', 'hero_image',
        'theme_color', 'accent_color', 'is_featured', 'status', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'is_featured'  => 'boolean',
        ];
    }

    /* ================= Relasi ================= */

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class)->orderBy('sort_order');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /* ================= Scope ================= */

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeUniverse(Builder $query, string $universe): Builder
    {
        return $query->where('universe', $universe);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('release_date');
    }

    /* ================= Helper ================= */

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getReleaseYearAttribute(): ?string
    {
        return $this->release_date?->format('Y');
    }
}
