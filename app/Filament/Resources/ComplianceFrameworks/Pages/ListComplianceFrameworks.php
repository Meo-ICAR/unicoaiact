<?php

namespace App\Filament\Resources\ComplianceFrameworks\Pages;

use App\Filament\Resources\ComplianceFrameworks\ComplianceFrameworkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListComplianceFrameworks extends ListRecords
{
    protected static string $resource = ComplianceFrameworkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
