<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;


class CreateBarang extends CreateRecord
{
    protected static string $resource = BarangResource::class;

    //tanpa desc
    // protected function getCreatedNotificationTitle(): ?string
    // {
    //     return 'Operator registered';
    // }

    //pake desc dna gamabr
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Operator registered')
            ->icon('heroicon-o-user')
            ->iconColor('success')
            ->color('success')
            ->duration(2000)
            ->body('Operator Succesfully registered');
    }
}
