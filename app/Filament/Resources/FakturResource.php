<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\CustomerModel;
use Filament\Tables;
use App\Models\Faktur;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FakturModel;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FakturResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FakturResource\RelationManagers;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

use function Laravel\Prompts\select;

class FakturResource extends Resource
{
    protected static ?string $model = FakturModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_faktur')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('...')
                    ->label('Data Code'),
                TextInput::make('kode_customer')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('...')
                    ->label('Operation Code'),
                Select::make('customer_id')
                    ->relationship('customer', 'nama_customer')
                    ->required()
                    ->placeholder('...')
                    ->label('Operation Name'),
                TextInput::make('ket_faktur')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('...')
                    ->label('Data desc'),
                TextInput::make('total')
                    ->required()
                    ->autocomplete(false)
                    ->placeholder('...')
                    ->label('etc'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_faktur')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Data_Code'),
                TextColumn::make('kode_customer')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Operation_Code'),
                TextColumn::make('customer_id')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Operation_ID'),
                TextColumn::make('ket_faktur')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Data_desc'),
                TextColumn::make('total')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('etc'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListFakturs::route('/'),
            'create' => Pages\CreateFaktur::route('/create'),
            'edit' => Pages\EditFaktur::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
