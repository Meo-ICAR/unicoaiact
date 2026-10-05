<?php

declare(strict_types=1);

namespace App\Filament\Resources\AiSystems\Actions;

use App\Models\AiSystem;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadComplianceReportAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'downloadComplianceReport';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Scarica Kit Compliance PDF')
            ->icon(Heroicon::OutlinedDocumentArrowDown)
            ->color('info')
            ->action(function (AiSystem $record): StreamedResponse {
                // Carica le relazioni necessarie per la scheda di trasparenza
                $record->loadMissing(['aiModels', 'latestRiskAssessment', 'organization', 'owner', 'pqcSignatures']);

                // Recupera l'ultima valutazione del rischio
                $latestRisk = $record->latestRiskAssessment;

                // Genera il PDF dal template Blade in formato A4
                $pdf = Pdf::loadView('pdf.ai-compliance-report', [
                    'record' => $record,
                    'latestRisk' => $latestRisk,
                ])->setPaper('a4', 'portrait');

                $dateSlug = now()->format('Y-m-d');
                $systemSlug = Str::slug($record->name);
                $filename = "Compliance_Report_{$systemSlug}_{$dateSlug}.pdf";

                return response()->streamDownload(
                    fn () => print ($pdf->output()),
                    $filename,
                    ['Content-Type' => 'application/pdf']
                );
            });
    }
}
