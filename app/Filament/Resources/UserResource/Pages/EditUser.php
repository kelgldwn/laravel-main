<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\DeleteAction; // ✅ import the correct DeleteAction
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            DeleteAction::make()
                ->disabled(fn ($record) => $record->roles->contains('name', 'admin'))
                ->before(function ($action, $record) {
                    if ($record->roles->contains('name', 'admin')) {
                        $action->failureNotificationTitle('Admin users cannot be deleted.');
                        $action->cancel();
                    }
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
