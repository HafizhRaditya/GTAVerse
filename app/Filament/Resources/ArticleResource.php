<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Konten';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Judul Artikel')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            TextInput::make('slug')
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('Kosongkan untuk dibuat otomatis dari judul.'),

            Select::make('user_id')
                ->label('Penulis')
                ->relationship('author', 'name')
                ->default(fn () => auth()->id())
                ->required()
                ->native(false),

            Select::make('category_id')
                ->label('Kategori')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->native(false),

            Select::make('game_id')
                ->label('Game Terkait')
                ->relationship('game', 'title')
                ->searchable()
                ->preload()
                ->native(false)
                ->helperText('Opsional — artikel akan muncul di halaman detail game tersebut.'),

            Textarea::make('excerpt')
                ->label('Ringkasan')
                ->rows(3)
                ->maxLength(500)
                ->columnSpanFull(),

            RichEditor::make('body')
                ->label('Isi Artikel')
                ->required()
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('articles/attachments')
                ->columnSpanFull(),

            FileUpload::make('featured_image')
                ->label('Gambar Utama')
                ->image()
                ->disk('public')
                ->directory('articles'),

            Select::make('status')
                ->options(['draft' => 'Draf', 'published' => 'Terbit'])
                ->default('draft')
                ->required()
                ->native(false),

            DateTimePicker::make('published_at')
                ->label('Tanggal Terbit')
                ->native(false)
                ->helperText('Kosongkan — akan terisi otomatis saat status diubah menjadi Terbit.'),

            Toggle::make('is_headline')
                ->label('Jadikan Headline')
                ->helperText('Tampil sebagai berita utama di beranda.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Gambar')
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(45)
                    ->weight('bold'),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'published' ? 'Terbit' : 'Draf')
                    ->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray'),

                TextColumn::make('published_at')
                    ->label('Terbit')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('views')
                    ->label('Dibaca')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('is_headline')
                    ->label('Headline')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(['draft' => 'Draf', 'published' => 'Terbit']),
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
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
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit'   => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
