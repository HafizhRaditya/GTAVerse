<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CharacterResource\Pages;
use App\Models\Character;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class CharacterResource extends Resource
{
    protected static ?string $model = Character::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Konten';

    protected static ?string $modelLabel = 'Karakter';

    protected static ?string $pluralModelLabel = 'Karakter';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('game_id')
                ->label('Game')
                ->relationship('game', 'title')
                ->searchable()
                ->preload()
                ->required()
                ->native(false),

            TextInput::make('name')
                ->label('Nama Karakter')
                ->required()
                ->maxLength(255),

            TextInput::make('slug')
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('Kosongkan untuk dibuat otomatis dari nama.'),

            TextInput::make('alias')
                ->label('Alias / Julukan')
                ->maxLength(255),

            TextInput::make('role')
                ->label('Peran')
                ->default('Protagonis Utama')
                ->maxLength(255),

            TextInput::make('voice_actor')
                ->label('Pengisi Suara')
                ->maxLength(255),

            Textarea::make('bio')
                ->label('Biografi')
                ->rows(6)
                ->columnSpanFull(),

            FileUpload::make('photo')
                ->label('Foto')
                ->image()
                ->disk('public')
                ->directory('characters'),

            Toggle::make('is_protagonist')
                ->label('Protagonis')
                ->default(true),

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
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('game.title')
                    ->label('Game')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('role')
                    ->label('Peran'),

                TextColumn::make('voice_actor')
                    ->label('Pengisi Suara')
                    ->toggleable(),

                IconColumn::make('is_protagonist')
                    ->label('Protagonis')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('game')
                    ->relationship('game', 'title'),
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
            'index'  => Pages\ListCharacters::route('/'),
            'create' => Pages\CreateCharacter::route('/create'),
            'edit'   => Pages\EditCharacter::route('/{record}/edit'),
        ];
    }
}
