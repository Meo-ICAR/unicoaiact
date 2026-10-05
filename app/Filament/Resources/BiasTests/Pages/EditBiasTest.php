<?php

namespace App\Filament\Resources\BiasTests\Pages;

use App\Filament\Resources\BiasTests\BiasTestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBiasTest extends EditRecord
{
    protected static string $resource = BiasTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
