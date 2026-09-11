<?php

declare(strict_types=1);

namespace App\Filament\Resources\AiSystems\Actions;

use App\Models\AiSystem;
use App\Models\PqcSignature;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ApproveAndSealAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'approveAndSeal';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Approva e Sigilla WORM')
            ->icon(Heroicon::OutlinedCheckBadge)
            ->color('success')
            ->visible(fn (AiSystem $record): bool => $record->approval_status === 'pending_approval'
                && $record->latestRiskAssessment?->risk_level !== 'prohibited')
            ->modalHeading('Approvazione e Sigillo Crittografico WORM')
            ->modalDescription('Stai per approvare questo sistema IA e registrare una firma Post-Quantistica (PQC) a valore legale.')
            ->modalSubmitActionLabel('Approva e Apponi Sigillo PQC')
            ->schema([
                Textarea::make('approval_notes')
                    ->label('Note del CTO / Compliance Officer (Opzionale)')
                    ->placeholder('Inserire eventuali note di conformità, raccomandazioni o condizioni di rilascio...')
                    ->rows(3),
            ])
            ->action(function (AiSystem $record, array $data): void {
                $user = auth()->user();
                $userName = $user?->name ?? 'System Administrator';

                // 1. Un sistema IA con rischio 'prohibited' (Art. 5) non può mai essere approvato,
                // indipendentemente dallo stato del pulsante lato UI.
                if ($record->latestRiskAssessment?->risk_level === 'prohibited') {
                    throw new RuntimeException("Il sistema '{$record->name}' è classificato a rischio proibito (Art. 5 EU AI Act) e non può essere approvato.");
                }

                // 2. Verifica la disponibilità della chiave del sigillo prima di mutare qualsiasi stato,
                // così un'approvazione non resta mai priva del sigillo WORM in caso di errore.
                $secretKey = config('services.pqc_worm.secret');

                if (! is_string($secretKey) || $secretKey === '') {
                    throw new RuntimeException('PQC_WORM_SECRET_KEY non configurata: impossibile apporre un sigillo WORM a valore legale.');
                }

                DB::transaction(function () use ($record, $data, $user, $userName, $secretKey): void {
                    // 3. Aggiorna lo stato di approvazione
                    $record->update([
                        'approval_status' => 'approved',
                    ]);

                    // 4. Genera il sigillo di integrità WORM (HMAC-SHA3-512)
                    $payloadData = json_encode([
                        'ai_system_id' => $record->id,
                        'name' => $record->name,
                        'version' => $record->version,
                        'approved_by' => $user?->id,
                        'approved_at' => now()->toIso8601String(),
                        'notes' => $data['approval_notes'] ?? null,
                    ], JSON_THROW_ON_ERROR);

                    $dataHash = hash('sha3-512', $payloadData);
                    $pqcSignature = base64_encode(hash_hmac('sha3-512', $dataHash, $secretKey));

                    PqcSignature::create([
                        'signable_type' => AiSystem::class,
                        'signable_id' => $record->id,
                        'hash_algorithm' => 'HMAC-SHA3-512',
                        'data_hash' => $dataHash,
                        'pqc_signature' => $pqcSignature,
                        'sealed_at' => now(),
                    ]);

                    // 5. Registra attività su Spatie ActivityLog
                    activity()
                        ->performedOn($record)
                        ->causedBy($user)
                        ->withProperties([
                            'approval_notes' => $data['approval_notes'] ?? null,
                            'data_hash' => $dataHash,
                            'pqc_signature' => $pqcSignature,
                        ])
                        ->log("Sistema IA approvato da {$userName} e ritenuto conforme all'EU AI Act");
                });

                // 6. Invia Notifica Filament di successo
                Notification::make()
                    ->title('Sistema Approvato e Registro Aggiornato')
                    ->body("Il sistema '{$record->name}' è stato approvato con successo e il sigillo PQC è stato registrato.")
                    ->success()
                    ->send();
            });
    }
}
