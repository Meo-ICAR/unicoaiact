<?php

namespace App\Filament\Resources\FriaAssessments\Pages;

use App\Filament\Resources\FriaAssessments\FriaAssessmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFriaAssessment extends EditRecord
{
    protected static string $resource = FriaAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
