<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TodoResource\Pages;
use App\Models\Todo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TodoResource extends Resource
{
    protected static ?string $model = Todo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Radio::make('is_long_term')
                    ->boolean()
                    ->default(true)
                    ->reactive()
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->native(false)
                    ->default(fn () => now()->startOfMonth())
                    ->displayFormat(fn ($get) => $get('is_long_term') ? 'M Y' : 'Y-d-m')
                    ->closeOnDateSelection()
                    ->required(),
                Forms\Components\DatePicker::make('grace_period_extends_till')
                    ->native(false)
                    ->default(fn () => now()->startOfMonth())
                    ->displayFormat(fn ($get) => $get('is_long_term') ? 'M Y' : 'Y-d-m')
                    ->closeOnDateSelection()
                    ->required(),
                Forms\Components\Select::make('completed_by')
                    ->relationship('user', 'name')
                    ->nullable(),
                Forms\Components\DatePicker::make('completed_at')
                    ->native(false)
                    ->default(fn () => now()->startOfMonth())
                    ->displayFormat('Y-m-d H:i:s')
                    ->closeOnDateSelection()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTodos::route('/'),
            'edit' => Pages\EditTodo::route('/{record}/edit'),
        ];
    }
}
