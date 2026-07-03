<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Character;
use App\Models\Game;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Game', Game::count())
                ->description('3D Universe & HD Universe')
                ->icon('heroicon-o-rocket-launch')
                ->color('info'),

            Stat::make('Artikel Terbit', Article::where('status', 'published')->count())
                ->description(Article::where('status', 'draft')->count() . ' draf menunggu')
                ->icon('heroicon-o-newspaper')
                ->color('success'),

            Stat::make('Karakter', Character::count())
                ->description('Profil protagonis & tokoh penting')
                ->icon('heroicon-o-user-group')
                ->color('warning'),

            Stat::make('Total Dibaca', number_format((int) Article::sum('views'), 0, ',', '.'))
                ->description('Akumulasi views seluruh artikel')
                ->icon('heroicon-o-eye')
                ->color('primary'),
        ];
    }
}
