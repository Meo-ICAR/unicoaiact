<?php

namespace App\Filament\Resources\PqcSignatures\Pages;

use App\Filament\Resources\PqcSignatures\PqcSignatureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPqcSignatures extends ListRecords
{
    protected static string $resource = PqcSignatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
