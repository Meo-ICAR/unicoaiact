<?php

namespace App\Filament\Resources\ComplianceFrameworks\Pages;

use App\Filament\Resources\ComplianceFrameworks\ComplianceFrameworkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditComplianceFramework extends EditRecord
{
    protected static string $resource = ComplianceFrameworkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
