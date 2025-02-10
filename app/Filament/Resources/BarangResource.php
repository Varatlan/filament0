<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BarangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Operator';
    protected static ?string $navigationGroup = 'Arknight';
    protected static ?string $slug = 'Operator';

    public static ?string $label = 'Operator';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_barang')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('...')
                    ->label('Name'),
                TextInput::make('kode_barang')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('...')
                    ->label('ID'),
                TextInput::make('harga')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('...')
                    ->label('payment'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Name'),
                TextColumn::make('kode_barang')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('ID'),
                TextColumn::make('harga')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Payment'),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
