<?php

declare(strict_types=1);

namespace App\Filament\Resources\RiskAssessments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RiskAssessmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificazione Sistema')
                    ->description('Selezionare il sistema di intelligenza artificiale oggetto della valutazione.')
                    ->schema([
                        Select::make('ai_system_id')
                            ->label('Sistema IA')
                            ->relationship('aiSystem', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Section::make('Classificazione del Rischio')
                    ->description('Classificazione del livello di rischio ai sensi del Regolamento UE 2024/1689 (EU AI Act).')
                    ->schema([
                        Radio::make('risk_level')
                            ->label('Livello di Rischio')
                            ->options([
                                'prohibited' => 'Proibito (Rischio Inaccettabile)',
                                'high' => 'Alto Rischio (High-Risk AI System)',
                                'limited' => 'Rischio Limitato (Obblighi di Trasparenza)',
                                'minimal' => 'Rischio Minimo / Nessun Rischio',
                            ])
                            ->descriptions([
                                'prohibited' => 'Sistemi espressamente vietati ai sensi dell\'Art. 5 dell\'EU AI Act (es. manipolazione comportamentale, social scoring, identificazione biometrica in tempo reale).',
                                'high' => 'Sistemi soggetti a requisiti di conformità stringenti e FRIA ai sensi dell\'Allegato III (es. infrastrutture critiche, gestione risorse umane, biometria).',
                                'limited' => 'Sistemi soggetti principalmente agli obblighi di trasparenza ai sensi dell\'Art. 50 (es. chatbot, generatori di deepfake).',
                                'minimal' => 'Sistemi privi di obblighi normativi cogenti ma incoraggiati all\'adozione di codici di condotta volontari.',
                            ])
                            ->required(),

                        Toggle::make('is_annex_iii')
                            ->label('Incluso nell\'Allegato III (Alto Rischio)')
                            ->helperText('Indica se il sistema rientra in uno dei settori ad alto rischio previsti dall\'Allegato III.')
                            ->default(false),

                        Textarea::make('justification')
                            ->label('Giustificazione della Classificazione')
                            ->placeholder('Fornire la motivazione legale e tecnica alla base della classificazione del rischio...')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Firma e Valutatore')
                    ->description('Informazioni sulla responsabilità della valutazione e data di finalizzazione.')
                    ->schema([
                        Select::make('evaluated_by')
                            ->label('Valutato da')
                            ->relationship('evaluator', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        DatePicker::make('completed_at')
                            ->label('Data Completamento Valutazione')
                            ->default(now()),
                    ]),
            ]);
    }
}
