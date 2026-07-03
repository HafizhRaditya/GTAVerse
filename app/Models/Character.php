<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Character extends Model
{
    use HasSlug;

    protected string $slugSource = 'name';

    protected $fillable = [
        'game_id', 'name', 'slug', 'alias', 'role',
        'voice_actor', 'bio', 'photo', 'is_protagonist', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_protagonist' => 'boolean',
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function scopeProtagonists(Builder $query): Builder
    {
        return $query->where('is_protagonist', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Inisial nama untuk avatar monogram bila foto belum diunggah. */
    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn ($word) => mb_substr($word, 0, 1))
            ->take(2)
            ->implode('');
    }
}
