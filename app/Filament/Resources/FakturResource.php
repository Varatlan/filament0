<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use App\Models\Faktur;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FakturModel;
use App\Models\CustomerModel;
use Doctrine\DBAL\ColumnCase;
use Filament\Resources\Resource;

use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use function Laravel\Prompts\textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FakturResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Filament\Resources\FakturResource\RelationManagers;
use Filament\Forms\Get;

class FakturResource extends Resource
{
  protected static ?string $model = FakturModel::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('kode_faktur')
          ->columnSpan(2),
        DatePicker::make('tanggal_faktur')
          ->columnSpan([
            'default' => 2,
            'md' => 1,
            'lg' => 1,
            'xl' => 1,
          ]),
        Select::make('customer_id')
          ->reactive()
          ->relationship('customer', 'nama_customer')
          ->columnSpan([
            'default' => 2,
            'md' => 1,
            'lg' => 1,
            'xl' => 1,
          ])
          ->afterStateUpdated(function ($state, callable $set) {
            $customer = CustomerModel::find($state);

            if ($customer) {
              $set('kode_customer', $customer->kode_customer);
            }
          })
          ->afterStatehydrated(function ($state, callable $set) {
            $customer = CustomerModel::find($state);

            if ($customer) {
              $set('kode_customer', $customer->kode_customer);
            }
          }),
        TextInput::make('kode_customer')
          // ->disabled()
          ->reactive()
          ->columnSpan(2),
        Repeater::make('detail')
          ->relationship()
          ->schema([
            Select::make('barang_id')
              ->columnSpan([
                'default' => 2,
                'md' => 1,
                'lg' => 1,
                'xl' => 1,
              ])
              ->reactive()
              ->relationship('barang', 'nama_barang')
              ->afterStateUpdated(function ($state, callable $set) {
                $barang = Barang::find($state);

                if ($barang) {
                  $set('harga', $barang->harga);
                  $set('nama_barang', $barang->nama_barang);
                }
              }),
            TextInput::make('nama_barang')
              // ->disabled()
              ->columnSpan([
                'default' => 2,
                'md' => 1,
                'lg' => 1,
                'xl' => 1,
              ]),
            TextInput::make('harga')
              ->prefix('LMD')
              ->columnSpan([
                'default' => 2,
                'md' => 1,
                'lg' => 1,
                'xl' => 1,
              ])
              ->numeric(),
            TextInput::make('qty')
              ->columnSpan([
                'default' => 2,
                'md' => 1,
                'lg' => 1,
                'xl' => 1,
              ])
              ->reactive()
              ->afterStateUpdated(function (Set $set, $state, Get $get) {
                $tampungHarga = $get('harga');
                $set('hasil_qty', intval($state * $tampungHarga));
              })
              ->numeric(),
            TextInput::make('hasil_qty')
              ->columnSpan([
                'default' => 2,
                'md' => 1,
                'lg' => 1,
                'xl' => 1,
              ])
              ->numeric(),
            TextInput::make('diskon')
              ->columnSpan([
                'default' => 2,
                'md' => 1,
                'lg' => 1,
                'xl' => 1,
              ])
              ->reactive()
              ->afterStateUpdated(function (Set $set, $state, Get $get) {
                $hasilQTY = $get('hasil_qty');
                $diskon = $hasilQTY * ($state / 100);
                $hasil = $hasilQTY - $diskon;

                $set('subtotal', intval($hasil));
              })
              ->numeric(),
            TextInput::make('subtotal')
              ->columnSpan([
                'default' => 2,
                'md' => 1,
                'lg' => 1,
                'xl' => 1,
              ])
              ->numeric(),
          ])
          ->live()
          ->columnSpan(2),
        textarea::make('ket_faktur')
          ->columnSpan(2),
        TextInput::make('total')
          ->placeholder(function (Set $set, Get $get) {
            $detail = collect($get('detail'))->pluck('subtotal')->sum();
            if ($detail == null) {
              $set('total', 0);
            } else {
              $set('total', $detail);
            }
          })
          ->columnSpan([
            'default' => 2,
            'md' => 1,
            'lg' => 1,
            'xl' => 1,
          ]),
        TextInput::make('nominal_charge')
          ->columnSpan([
            'default' => 2,
            'md' => 1,
            'lg' => 1,
            'xl' => 1,
          ])
          ->reactive()
          ->afterStateUpdated(function (Set $set, $state, Get $get) {
            $total = $get('total');
            $charge = $total * ($state / 100);
            $hasil = $total + $charge;

            $set('total_final', $hasil);
            $set('charge', $charge);
          }),
        TextInput::make('charge')
          // ->disabled()
          ->columnSpan(2),
        TextInput::make('total_final')
          ->columnSpan(2),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([

        TextColumn::make('kode_faktur'),
        TextColumn::make('tanggal_faktur'),
        TextColumn::make('kode_customer'),
        TextColumn::make('customer.nama_customer'),
        TextColumn::make('ket_faktur'),
        TextColumn::make('total'),
        TextColumn::make('nominal_charge'),
        TextColumn::make('charge'),
        TextColumn::make('total_final'),
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
