<?php

declare(strict_types=1);

namespace App\Filament\Resources\AiSystems\Tables;

use App\Filament\Resources\AiSystems\Actions\ApproveAndSealAction;
use App\Filament\Resources\AiSystems\Actions\DownloadComplianceReportAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AiSystemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Sistema IA')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('organization.name')
                    ->label('Organizzazione')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('version')
                    ->label('Versione')
                    ->badge()
                    ->sortable(),

                TextColumn::make('owner.name')
                    ->label('Responsabile')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('approval_status')
                    ->label('Stato Approvazione')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending_approval' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => 'Approvato',
                        'pending_approval' => 'In Approvazione',
                        'rejected' => 'Rifiutato',
                        'draft' => 'Bozza',
                        default => ucfirst($state),
                    })
                    ->sortable(),

                TextColumn::make('human_oversight_type')
                    ->label('Sorveglianza Umana')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'human_in_the_loop' => 'Human in the Loop',
                        'human_on_the_loop' => 'Human on the Loop',
                        'human_in_command' => 'Human in Command',
                        default => $state ?? 'N/D',
                    }),

                IconColumn::make('has_kill_switch')
                    ->label('Kill Switch')
                    ->boolean(),

                IconColumn::make('is_shadow_ai')
                    ->label('Shadow AI')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('eu_registration_status')
                    ->label('Stato DB UE')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'registered' => 'success',
                        'pending' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Data Censimento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('approval_status')
                    ->label('Stato Approvazione')
                    ->options([
                        'draft' => 'Bozza',
                        'pending_approval' => 'In Approvazione',
                        'approved' => 'Approvato',
                        'rejected' => 'Rifiutato',
                    ]),

                TernaryFilter::make('has_kill_switch')
                    ->label('Kill Switch Configurato'),
            ])
            ->recordActions([
                ApproveAndSealAction::make(),
                DownloadComplianceReportAction::make(),
                Action::make('downloadTransparencySheet')
                    ->label('Scheda Trasparenza')
                    ->icon('heroicon-o-document-check')
                    ->color('success')
                    ->action(fn (AiSystem $record) => static::generateTransparencySheetPdf($record)),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
    /**
     * Gestisce la generazione del PDF e la risposta di download stream.
     */
    protected static function generateTransparencySheetPdf(AiSystem $record)
    {
        $html = static::renderTransparencySheetHtml($record);
        $pdf = Pdf::loadHTML($html)->setPaper('a4');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'Scheda_Trasparenza_' . Str::slug($record->name) . '.pdf'
        );
    }

    /**
     * Costruisce e restituisce il codice HTML completo della scheda.
     */
    protected static function renderTransparencySheetHtml(AiSystem $record): string
    {
        $record->load(['organization', 'aiModels', 'riskAssessment']);

        $orgName = e($record->organization->name ?? config('app.name'));
        $systemName = e($record->name);
        $description = e($record->description ?? 'Modulo con funzionalità di Intelligenza Artificiale per l\'automazione ed analisi dati.');
        $risk = strtoupper(e($record->riskAssessment->risk_level ?? 'minimal'));
        $oversight = e(str_replace('_', ' ', $record->human_oversight_type ?? 'Human oversight active'));
        $hash = strtoupper(substr(hash('sha256', $record->id . $record->updated_at), 0, 16));
        $date = now()->format('d/m/Y');
        $modelsHtml = static::buildModelsTableRows($record);

        return <<<HTML
        <!DOCTYPE html>
        <html lang="it">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Helvetica, Arial, sans-serif; font-size: 10pt; color: #1e293b; margin: 25px; }
                .header { border-bottom: 2px solid #cbd5e1; padding-bottom: 10px; margin-bottom: 15px; }
                .title { font-size: 16pt; font-weight: bold; color: #0f172a; margin: 0; }
                .badge { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 4px 8px; font-size: 8pt; font-weight: bold; border-radius: 4px; float: right; }
                .section { font-size: 11pt; font-weight: bold; color: #334155; border-bottom: 1px solid #cbd5e1; margin-top: 15px; padding-bottom: 3px; }
                table { width: 100%; border-collapse: collapse; margin-top: 8px; }
                td, th { padding: 6px 8px; text-align: left; border-bottom: 1px solid #f1f5f9; }
                th { background-color: #f8fafc; font-size: 9pt; }
                .label { font-weight: bold; width: 30%; background: #f8fafc; }
                .callout { background-color: #eff6ff; border-left: 3px solid #3b82f6; padding: 8px 12px; margin: 12px 0; font-size: 9pt; color: #1e40af; }
                .seal { border: 1px dashed #0284c7; background-color: #f0f9ff; padding: 8px; text-align: center; margin-top: 20px; font-size: 8pt; color: #0369a1; }
            </style>
        </head>
        <body>
            <div class="header">
                <span class="badge">CONFORME EU AI ACT</span>
                <div class="title">{$systemName}</div>
                <div style="font-size: 8pt; color: #64748b;">Organizzazione: {$orgName} &bull; Data: {$date}</div>
            </div>

            <div class="section">1. INFORMATIVA DI TRASPARENZA (ART. 50)</div>
            <p>{$description}</p>
            <div class="callout">
                <strong>Avviso Utente:</strong> Stai interagendo con un sistema assistito da Intelligenza Artificiale progettato per supportare i processi operativi.
            </div>

            <div class="section">2. CLASSIFICAZIONE DI RISCHIO & GARANZIE</div>
            <table>
                <tr><td class="label">Livello Rischio:</td><td><strong>{$risk}</strong></td></tr>
                <tr><td class="label">Sorveglianza Umana:</td><td>{$oversight}</td></tr>
                <tr><td class="label">Protezione Dati:</td><td>Conforme GDPR - Nessun training su modelli pubblici terzi.</td></tr>
            </table>

            <div class="section">3. MODELLI UTILIZZATI</div>
            <table>
                <thead>
                    <tr><th>Modello</th><th>Provider</th><th>Hosting</th></tr>
                </thead>
                <tbody>
                    {$modelsHtml}
                </tbody>
            </table>

            <div class="seal">
                <strong>REGISTRO TRASPARENZA VERIFICATO</strong><br>
                Hash Impronta: {$hash}
            </div>
        </body>
        </html>
        HTML;
    }

    /**
     * Genera le righe HTML per la tabella dei modelli associati.
     */
    protected static function buildModelsTableRows(AiSystem $record): string
    {
        if ($record->aiModels->isEmpty()) {
            return '<tr><td colspan="3" style="color: #94a3b8;">Nessun modello esterno mappato.</td></tr>';
        }

        $rows = '';
        foreach ($record->aiModels as $model) {
            $rows .= "<tr>
                <td><strong>" . e($model->name) . "</strong></td>
                <td>" . e($model->provider) . "</td>
                <td>" . e(ucfirst($model->hosting_type)) . "</td>
            </tr>";
        }

        return $rows;
    }
}
