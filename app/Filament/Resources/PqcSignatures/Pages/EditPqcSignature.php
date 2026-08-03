<?php

namespace App\Filament\Resources\PqcSignatures\Pages;

use App\Filament\Resources\PqcSignatures\PqcSignatureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPqcSignature extends EditRecord
{
    protected static string $resource = PqcSignatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
