<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\MetadatasRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Posts';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label(__('Title'))
                                    ->reactive()
                                    ->live(true)
                                    ->afterStateUpdated(function ($set, $state) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('slug')
                                    ->label(__('Slug'))
                                    ->nullable()
                                    ->maxLength(255),
                                Forms\Components\MarkdownEditor::make('content')
                                    ->label(__('Content'))
                                    ->columnSpanFull()
                                    ->visible(setting('site_post_editor') == 'markdown'),
                                \FilamentEditorJs\Forms\Components\EditorJs::make('editorjs_blocks')
                                    ->label(__('Content'))
                                    ->columnSpanFull()
                                    ->visible(setting('site_post_editor') == 'editorjs'),
                                \Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor::make('content')
                                    ->label(__('Content'))
                                    ->minHeight(300)
                                    ->required()
                                    ->visible(setting('site_post_editor') != 'markdown' && setting('site_post_editor') != 'editorjs')
                                    ->columnSpanFull(),
                                Forms\Components\Fieldset::make('Seo')
                                    ->schema([
                                        \RalphJSmit\Filament\SEO\SEO::make(),
                                    ]),
                            ])
                            ->columnSpan(2),
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Fieldset::make('Author')
                                    ->label(__('Author'))
                                    ->schema([
                                        Forms\Components\Select::make('user_id')
                                            ->label(__('Author'))
                                            ->default(auth()->user()->id)
                                            ->searchable()
                                            ->relationship('user', 'name')
                                            ->columnSpanFull(),
                                        Forms\Components\SpatieTagsInput::make('tags')
                                            ->label(__('Tags'))
                                            ->type('post')
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('categories')
                                            ->label(__('Categories'))
                                            ->multiple()
                                            ->relationship('categories', 'title')
                                            ->columnSpanFull(),

                                    ])
                                    ->columns(3),
                                Forms\Components\Fieldset::make('Excerpt')
                                    ->label(__('Excerpt'))
                                    ->schema([
                                        Forms\Components\Textarea::make('excerpt')
                                            ->label(__('Excerpt'))
                                            ->hiddenLabel()
                                            ->rows(5)
                                            ->nullable()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ]),
                                Forms\Components\Fieldset::make('Options')
                                    ->label(__('Options'))
                                    ->schema([
                                        Forms\Components\FileUpload::make('main_image')
                                            ->label(__('Main Image'))
                                            ->columnSpanFull(),
                                        Forms\Components\Checkbox::make('is_featured')
                                            ->label(__('Is Featured'))
                                            ->columnSpanFull()
                                            ->nullable(),
                                        Forms\Components\Checkbox::make('is_sponsored')
                                            ->label(__('Is Sponsored'))
                                            ->columnSpanFull()
                                            ->nullable(),
                                        Forms\Components\Checkbox::make('allowed_comment')
                                            ->label(__('Allowed comment'))
                                            ->default(true)
                                            ->columnSpanFull()
                                            ->nullable(),
                                        Forms\Components\Select::make('template')
                                            ->label(__('Template'))
                                            ->options(collect(\App\Enums\PostTemplate::cases())->pluck('name', 'value'))
                                            ->default('default')
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('status')
                                            ->label(__('Status'))
                                            ->options(collect(\App\Enums\PostStatus::cases())->pluck('name'))
                                            ->default(1)
                                            ->columnSpanFull()
                                    ])
                                    ->columns(3),
                            ])
                            ->columnSpan(1),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('template')
                    ->label(__('Template'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MetadatasRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getnavigationGroup(): string
    {
        return __('Posts');
    }

    public static function getModelLabel(): string
    {
        return __('Post');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Posts');
    }
}
