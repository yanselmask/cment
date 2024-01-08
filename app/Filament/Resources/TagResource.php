<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagResource extends Resource
{
    protected static ?string $model = \App\Models\Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name.' . config('app.locale'))
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug.' . config('app.locale'))
                    ->label(__('Slug'))
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'post' => 'Post',
                        'page' => 'Page'
                    ]),
                Forms\Components\TextInput::make('order_column')
                    ->label(__('Order Column'))
                    ->type('number')
                    ->maxLength(255),
                Forms\Components\ColorPicker::make('color')
                    ->label(__('Color')),
                Forms\Components\ColorPicker::make('background')
                    ->label(__('Background')),
                Forms\Components\FileUpload::make('image')
                    ->label(__('Image'))
                    ->image()
                    ->imageEditor()
                    ->directory('tags'),
                Forms\Components\TextInput::make('icon')
                    ->label(__('Icon'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_column')
                    ->label(__('Order Column'))
                    ->sortable()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }

    public static function getnavigationGroup(): string
    {
        return __('Posts');
    }

    public static function getModelLabel(): string
    {
        return __('Tag');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tags');
    }
}
