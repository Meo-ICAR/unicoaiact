<?php

declare(strict_types=1);

namespace App\Filament\Resources\AiSystems\Pages;

use App\Filament\Resources\AiSystems\AiSystemResource;
use App\Models\Organization;
use App\Models\RiskAssessment;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Support\HtmlString;

class CreateAiSystem extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = AiSystemResource::class;

    public function getSteps(): array
    {
        return [
            Step::make('Identificazione Feature')
                ->description('Informazioni generali sul sistema di intelligenza artificiale')
                ->icon('heroicon-o-cpu-chip')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome del Sistema / Feature IA')
                        ->placeholder('es. Generatore E-mail CRM')
                        ->required()
                        ->maxLength(255),

                    Select::make('aiModels')
                        ->label('Modelli IA / LLM Utilizzati')
                        ->relationship('aiModels', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->helperText('Selezionare uno o più modelli (es. GPT-4o, Claude 3.5 Sonnet, Llama 3).')
                        ->required(),

                    Textarea::make('description')
                        ->label('Descrizione d\'Uso')
                        ->placeholder('Breve spiegazione del caso d\'uso e del perimetro operativo...')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Step::make('Algoritmo Classificazione Rischio')
                ->description('Valutazione guidata dell\'EU AI Act (Regolamento UE 2024/1689)')
                ->icon('heroicon-o-shield-exclamation')
                ->schema([
                    Toggle::make('generates_content')
                        ->label('Genera testo, immagini, audio o video visibili all\'utente finale?')
                        ->helperText('Sistemi di IA generativa destinati all\'interazione diretta o alla creazione di contenuti sintetici.')
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set): void {
                            self::updateCalculatedRisk($get, $set);
                        }),

                    Toggle::make('annex_iii_scope')
                        ->label('Valuta o prende decisioni su HR, Credito, Salute, Biometria o Categorie Proibite?')
                        ->helperText('Spuntare se il sistema rientra nelle aree ad alto rischio dell\'Allegato III dell\'EU AI Act.')
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set): void {
                            self::updateCalculatedRisk($get, $set);
                        }),

                    Toggle::make('internal_only')
                        ->label('È uno strumento ad uso puramente interno/backoffice?')
                        ->helperText('Strumenti senza impatto diretto su clienti esterni o persone fisiche vulnerabili.')
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set): void {
                            self::updateCalculatedRisk($get, $set);
                        }),

                    Hidden::make('risk_level')
                        ->default('minimal'),

                    Placeholder::make('risk_level_display')
                        ->label('Livello di Rischio Calcolato (EU AI Act)')
                        ->content(function (Get $get): HtmlString {
                            $risk = $get('risk_level') ?? 'minimal';

                            return match ($risk) {
                                'high' => new HtmlString('<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200">⚠️ ALTO RISCHIO (High-Risk AI System)</span>'),
                                'limited' => new HtmlString('<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">ℹ️ RISCHIO LIMITATO (Obblighi Trasparenza Art. 50)</span>'),
                                default => new HtmlString('<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">✅ RISCHIO MINIMO / NESSUN RISCHIO</span>'),
                            };
                        }),

                    Placeholder::make('high_risk_callout')
                        ->label('')
                        ->hidden(fn (Get $get): bool => $get('risk_level') !== 'high')
                        ->content(new HtmlString('
                            <div class="p-4 rounded-lg bg-amber-50 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-200">
                                <strong class="font-bold flex items-center gap-2 text-base">
                                    ⚠️ AVVISO ALTO RISCHIO (EU AI Act - Allegato III)
                                </strong>
                                <p class="mt-1 text-sm leading-relaxed">
                                    Questo sistema rientra nelle categorie ad <strong>Alto Rischio</strong>. Prima dell\'immissione sul mercato sono obbligatori:
                                    <ul class="list-disc list-inside mt-1 space-y-1">
                                        <li>Valutazione d\'impatto sui diritti fondamentali (FRIA - Art. 27).</li>
                                        <li>Implementazione di meccanismi di sorveglianza umana (Human Oversight - Art. 14).</li>
                                        <li>Registrazione nel database ufficiale UE dei sistemi ad alto rischio.</li>
                                    </ul>
                                </p>
                            </div>
                        ')),
                ]),

            Step::make('Evidenze & Controlli Rapidi')
                ->description('Requisiti operativi e caricamento evidenze di conformità')
                ->icon('heroicon-o-document-check')
                ->schema([
                    // Sezione per Rischio Limitato (Art. 50)
                    SpatieMediaLibraryFileUpload::make('disclaimer_evidence')
                        ->collection('disclaimers')
                        ->label('Screenshot Disclaimer IA (Trasparenza Art. 50)')
                        ->helperText('Caricare uno screenshot o evidenza visiva del disclaimer mostrato agli utenti finali.')
                        ->image()
                        ->hidden(fn (Get $get): bool => $get('risk_level') !== 'limited'),

                    // Sezione per Alto Rischio (Art. 14)
                    Select::make('human_oversight_type')
                        ->label('Tipologia Sorveglianza Umana (Human Oversight)')
                        ->options([
                            'human_in_the_loop' => 'Human-in-the-loop (L\'umano approva ogni singolo output)',
                            'human_on_the_loop' => 'Human-on-the-loop (L\'umano monitora e può intervenire)',
                            'human_in_command' => 'Human-in-command (L\'umano ha il controllo dell\'intero sistema)',
                        ])
                        ->required(fn (Get $get): bool => $get('risk_level') === 'high')
                        ->hidden(fn (Get $get): bool => $get('risk_level') !== 'high'),

                    Toggle::make('has_kill_switch')
                        ->label('Kill Switch Configurato')
                        ->helperText('Attivare se è presente una procedura/pulsante di arresto d\'emergenza immediato.')
                        ->default(false)
                        ->hidden(fn (Get $get): bool => $get('risk_level') !== 'high'),

                    Textarea::make('kill_switch_procedure')
                        ->label('Procedura d\'Emergenza / Kill Switch')
                        ->placeholder('Descrivere le modalità di spegnimento d\'emergenza o fallback...')
                        ->rows(3)
                        ->columnSpanFull()
                        ->hidden(fn (Get $get): bool => $get('risk_level') !== 'high' || ! $get('has_kill_switch')),

                    Placeholder::make('minimal_risk_notice')
                        ->label('')
                        ->content('Per i sistemi a rischio minimo non sono richiesti controlli o allegati obbligatori. È consigliata l\'adesione volontaria ai codici di condotta aziendali.')
                        ->hidden(fn (Get $get): bool => $get('risk_level') !== 'minimal'),
                ]),
        ];
    }

    private static function updateCalculatedRisk(Get $get, Set $set): void
    {
        $annexIII = (bool) $get('annex_iii_scope');
        $generatesContent = (bool) $get('generates_content');

        if ($annexIII) {
            $set('risk_level', 'high');
        } elseif ($generatesContent) {
            $set('risk_level', 'limited');
        } else {
            $set('risk_level', 'minimal');
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['owner_id'] = auth()->id() ?? 1;
        $data['approval_status'] = 'pending_approval';

        if (empty($data['organization_id'])) {
            $data['organization_id'] = Organization::first()?->id ?? 1;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $riskLevel = $this->data['risk_level'] ?? 'minimal';

        RiskAssessment::create([
            'ai_system_id' => $this->record->id,
            'risk_level' => $riskLevel,
            'justification' => match ($riskLevel) {
                'high' => 'Classificato ad Alto Rischio (EU AI Act - Allegato III) tramite censimento rapido Wizard.',
                'limited' => 'Classificato a Rischio Limitato (Art. 50 Obblighi di Trasparenza) tramite censimento rapido Wizard.',
                default => 'Classificato a Rischio Minimo tramite censimento rapido Wizard.',
            },
            'is_annex_iii' => $riskLevel === 'high',
            'evaluated_by' => auth()->id() ?? $this->record->owner_id,
            'completed_at' => now(),
        ]);
    }
}
