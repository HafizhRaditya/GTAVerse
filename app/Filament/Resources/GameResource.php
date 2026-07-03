<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Models\Game;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rocket-launch';

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Konten';

    protected static ?string $modelLabel = 'Game';

    protected static ?string $pluralModelLabel = 'Game';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Judul Game')
                ->required()
                ->maxLength(255),

            TextInput::make('slug')
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('Kosongkan untuk dibuat otomatis dari judul.'),

            Select::make('universe')
                ->label('Universe')
                ->options(['3D' => '3D Universe', 'HD' => 'HD Universe'])
                ->required()
                ->native(false),

            Select::make('status')
                ->options(['released' => 'Sudah Rilis', 'upcoming' => 'Akan Datang'])
                ->default('released')
                ->required()
                ->native(false),

            DatePicker::make('release_date')
                ->label('Tanggal Rilis')
                ->native(false),

            TextInput::make('platforms')
                ->label('Platform')
                ->placeholder('PlayStation 5, Xbox Series X|S, PC')
                ->maxLength(255),

            TextInput::make('setting')
                ->label('Latar Tempat & Waktu')
                ->placeholder('contoh: Vice City, 1986')
                ->maxLength(255),

            TextInput::make('tagline')
                ->maxLength(255),

            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(5)
                ->columnSpanFull(),

            FileUpload::make('cover_image')
                ->label('Gambar Sampul')
                ->image()
                ->disk('public')
                ->directory('games'),

            FileUpload::make('hero_image')
                ->label('Gambar Hero')
                ->image()
                ->disk('public')
                ->directory('games')
                ->helperText('Gambar besar untuk hero slider & animasi scroll beranda.'),

            ColorPicker::make('theme_color')
                ->label('Warna Tema')
                ->default('#ff2ea6')
                ->helperText('Dipakai sebagai latar gradien bila gambar belum diunggah.'),

            ColorPicker::make('accent_color')
                ->label('Warna Aksen')
                ->default('#7c3aed'),

            Toggle::make('is_featured')
                ->label('Game Unggulan')
                ->helperText('Tampil di hero slider & bagian animasi scroll pada beranda.'),

            TextInput::make('sort_order')
                ->label('Urutan Tampil')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Sampul')
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('universe')
                    ->badge()
                    ->color(fn (string $state): string => $state === '3D' ? 'info' : 'warning'),

                TextColumn::make('release_date')
                    ->label('Rilis')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'released' ? 'Rilis' : 'Segera')
                    ->color(fn (string $state): string => $state === 'released' ? 'success' : 'danger'),

                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('universe')
                    ->options(['3D' => '3D Universe', 'HD' => 'HD Universe']),
                SelectFilter::make('status')
                    ->options(['released' => 'Sudah Rilis', 'upcoming' => 'Akan Datang']),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit'   => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
