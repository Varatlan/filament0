<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CustomerModel;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource\RelationManagers;
use Filament\Forms\Components\TextInput;

class CustomerResource extends Resource
{
    protected static ?string $model = CustomerModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Operation';
    protected static ?string $navigationGroup = 'Arknight';
    protected static ?string $slug = 'Operation';

    public static ?string $label = 'Operation';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_customer')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('Name...')
                    ->label('Operation Name'),
                TextInput::make('kode_customer')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('ID...')
                    ->label('Operation ID'),
                TextInput::make('alamat_customer')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('Location...')
                    ->label('Operation Location'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_customer')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Name'),
                TextColumn::make('kode_customer')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('ID'),
                TextColumn::make('alamat_customer')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Lokasi'),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
