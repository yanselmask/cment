<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\MetadatasRelationManager;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Posts';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label(__('Slug'))
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('content')
                    ->label(__('Content'))
                    ->columnSpanFull()
                    ->visible(setting('site_page_editor') == 'markdown'),
                \FilamentEditorJs\Forms\Components\EditorJs::make('editorjs_blocks')
                    ->label(__('Content'))
                    ->columnSpanFull()
                    ->visible(setting('site_page_editor') == 'editorjs'),
                \Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor::make('content')
                    ->label(__('Content'))
                    ->minHeight(300)
                    ->required()
                    ->visible(setting('site_page_editor') != 'markdown' && setting('site_page_editor') != 'editorjs' && setting('site_page_editor') != 'grapejs')
                    ->columnSpanFull(),
                Forms\Components\Section::make(__('Edit in page builder(only for GrapeJS)'))
                    ->schema([
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make(__('Live Editor'))
                                ->url(route('pages.editor', request()->route('record') ?? 'not-found'))
                        ])
                    ])
                    ->visible(setting('site_page_editor') == 'grapejs' && request()->route('record')),
                Forms\Components\Section::make(__('Content(only for GrapeJS)'))
                    ->schema([
                        Forms\Components\View::make('filament.components.grapejs_info')
                    ])
                    ->visible(setting('site_page_editor') == 'grapejs' && !request()->route('record')),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Fieldset::make('Seo')
                                    ->schema([
                                        \RalphJSmit\Filament\SEO\SEO::make()
                                            ->columnSpanFull(),
                                    ]),
                            ])->columnSpan(1),
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Fieldset::make('Options')
                                    ->label(__('Options'))
                                    ->schema([
                                        Forms\Components\Select::make('user_id')
                                            ->label(__('Owner'))
                                            ->default(auth()->user()->id)
                                            ->searchable()
                                            ->relationship('user', 'name')
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('template')
                                            ->label(__('Template'))
                                            ->options(collect(\App\Enums\PageTemplate::cases())->pluck('name', 'value'))
                                            ->default('default'),
                                        Forms\Components\SpatieTagsInput::make('tags')
                                            ->label(__('Tags'))
                                            ->type('page'),
                                        Forms\Components\Select::make('status')
                                            ->label(__('Status'))
                                            ->options(collect(\App\Enums\PageStatus::cases())->pluck('name'))
                                            ->default(1)
                                            ->columnSpanFull(),

                                    ])
                                    ->columnSpanFull(),
                            ])->columnSpan(1),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getnavigationGroup(): string
    {
        return __('Posts');
    }

    public static function getModelLabel(): string
    {
        return __('Page');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Pages');
    }
}
