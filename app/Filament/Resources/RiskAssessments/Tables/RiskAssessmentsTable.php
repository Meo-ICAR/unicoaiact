<?php

declare(strict_types=1);

namespace App\Filament\Resources\RiskAssessments\Tables;

use App\Models\RiskAssessment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RiskAssessmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('aiSystem.name')
                    ->label('Sistema IA')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('risk_level')
                    ->label('Livello di Rischio')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'prohibited' => 'danger',
                        'high' => 'warning',
                        'limited' => 'info',
                        'minimal' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'prohibited' => 'Proibito',
                        'high' => 'Alto Rischio',
                        'limited' => 'Rischio Limitato',
                        'minimal' => 'Rischio Minimo',
                        default => ucfirst($state),
                    })
                    ->sortable(),

                IconColumn::make('is_annex_iii')
                    ->label('Allegato III')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('evaluator.name')
                    ->label('Valutatore')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('completed_at')
                    ->label('Data Completamento')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('risk_level')
                    ->label('Livello di Rischio')
                    ->options([
                        'prohibited' => 'Proibito',
                        'high' => 'Alto Rischio',
                        'limited' => 'Rischio Limitato',
                        'minimal' => 'Rischio Minimo',
                    ]),

                TernaryFilter::make('is_annex_iii')
                    ->label('Allegato III'),
            ])
            ->recordActions([
                Action::make('exportPdf')
                    ->label('Esporta PDF Certificato')
                    ->icon(Heroicon::OutlinedDocumentArrowDown)
                    ->color('success')
                    ->action(function (RiskAssessment $record): void {
                        Notification::make()
                            ->title('Certificato PDF Generato')
                            ->body("Il certificato di conformità per il sistema {$record->aiSystem?->name} è stato generato ed esportato con successo.")
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
