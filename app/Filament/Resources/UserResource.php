<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\MetadatasRelationManager;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\RelationManager\PermissionRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('lastname')
                    ->label(__('Lastname'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->label(__('Username'))
                    ->alphaDash()
                    ->unique(ignoreRecord: true)
                    ->maxLength(25),
                Forms\Components\TextInput::make('email')
                    ->label(__('Email'))
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),

                //Password On Create AND On Edit
                Forms\Components\TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->visibleOn('create'),
                Forms\Components\TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255)
                    ->visibleOn('edit'),
                Forms\Components\Select::make('status')
                    ->label(__('Status'))
                    ->options(\App\Enums\UserStatus::getLabels())
                    ->default(1),
                Forms\Components\DatePicker::make('email_verified_at')
                    ->label(__('Email Verified')),
                Forms\Components\Textarea::make('about')
                    ->label(__('About'))
                    ->columnSpanFull()
                    ->rows(10)
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
                Tables\Columns\TextColumn::make('lastname')
                    ->label(__('Username'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->label(__('Username'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (User $model) => $model->status->getColor())
                    ->formatStateUsing(fn (User $model): string => $model->status->getLabel())
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \STS\FilamentImpersonate\Tables\Actions\Impersonate::make(),
                Tables\Actions\EditAction::make(),
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
            MetadatasRelationManager::class,
            RolesRelationManager::class,
            PermissionRelationManager::class

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getnavigationGroup(): string
    {
        return __('Users');
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }
}
