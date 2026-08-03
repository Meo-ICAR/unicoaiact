<?php

namespace App\Filament\Resources\BiasTests\Pages;

use App\Filament\Resources\BiasTests\BiasTestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBiasTests extends ListRecords
{
    protected static string $resource = BiasTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
