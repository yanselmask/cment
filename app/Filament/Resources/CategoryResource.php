<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = \App\Models\Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationGroup = 'Posts';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title.' . config('app.locale'))
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug.' . config('app.locale'))
                    ->label(__('Slug'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('order')
                    ->label(__('Order'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->label(__('Type'))
                    ->maxLength(255),
                Forms\Components\ColorPicker::make('color')
                    ->label(__('Color')),
                Forms\Components\ColorPicker::make('background')
                    ->label(__('Background')),
                Forms\Components\TextInput::make('x_icon')
                    ->label(__('Icon'))
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label(__('Image'))
                    ->image()
                    ->imageEditor()
                    ->directory('categories'),
                Forms\Components\Textarea::make('description')
                    ->label(__('Description'))
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->label(__('Order'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
            'sort' => Pages\CategoryTree::route('/sort'),
        ];
    }


    public static function getnavigationGroup(): string
    {
        return __('Posts');
    }

    public static function getModelLabel(): string
    {
        return __('Category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Categories');
    }
}
