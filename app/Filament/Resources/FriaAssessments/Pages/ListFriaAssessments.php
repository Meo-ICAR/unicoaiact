<?php

namespace App\Filament\Resources\FriaAssessments\Pages;

use App\Filament\Resources\FriaAssessments\FriaAssessmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFriaAssessments extends ListRecords
{
    protected static string $resource = FriaAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
