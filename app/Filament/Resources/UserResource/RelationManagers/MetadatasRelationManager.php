<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class MetadatasRelationManager extends RelationManager
{
    protected static string $relationship = 'metas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->reactive()
                    ->live()
                    ->options([
                        'text' => __('Text'),
                        'content' => __('Content'),
                        'markdown' => __('MarkDown')
                    ])
                    ->dehydrated(false)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
                    ->visible(fn ($get) => $get('type') == 'text')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('value')
                    ->visible(fn ($get) => $get('type') == 'content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\MarkdownEditor::make('value')
                    ->visible(fn ($get) => $get('type') == 'markdown')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('key')
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label(__('Key')),
                Tables\Columns\TextColumn::make('value')
                    ->label(__('Value')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                ]),
            ]);
    }
}
