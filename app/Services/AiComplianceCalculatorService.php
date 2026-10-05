<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Audit;
use App\Models\AuditAnswer;
use Spatie\Activitylog\Models\Activity;

class AiComplianceCalculatorService
{
    /**
     * Calcola il punteggio di conformità per un Audit e aggiorna lo stato ed il punteggio percentuale.
     */
    public function calculate(Audit $audit): Audit
    {
        $audit->loadMissing(['aiSystem.riskAssessments', 'answers.requirement']);

        // Recupera il livello di rischio del sistema IA tramite l'ultima valutazione del rischio
        $latestRiskAssessment = $audit->aiSystem?->riskAssessments()->latest('id')->first();
        $systemRiskLevel = $latestRiskAssessment?->risk_level;

        // Recupera tutte le risposte collegate all'audit
        $answers = $audit->answers;

        // Filtra le risposte applicabili al livello di rischio del sistema
        $applicableAnswers = $answers->filter(function (AuditAnswer $answer) use ($systemRiskLevel): bool {
            $requirement = $answer->requirement;
            if (!$requirement) {
                return false;
            }

            $applicableLevels = $requirement->applicable_risk_levels;

            // Se il requisito non specifica livelli o se non c'è una classificazione di rischio, è applicabile
            if (empty($applicableLevels) || !$systemRiskLevel) {
                return true;
            }

            return is_array($applicableLevels) && in_array($systemRiskLevel, $applicableLevels, true);
        });

        $totalApplicable = $applicableAnswers->count();

        if ($totalApplicable === 0) {
            $scorePercentage = 0.0;
        } else {
            $compliantCount = $applicableAnswers->where('is_compliant', true)->count();
            $scorePercentage = round(($compliantCount / $totalApplicable) * 100, 2);
        }

        // Determina lo stato: se score < 80% imposta 'non_compliant', altrimenti 'compliant'
        $status = $scorePercentage < 80.0 ? 'non_compliant' : 'compliant';

        // Aggiorna il modello Audit
        $audit->update([
            'score_percentage' => $scorePercentage,
            'status' => $status,
        ]);

        // Traccia l'operazione tramite Spatie ActivityLog
        activity()
            ->performedOn($audit)
            ->causedBy(auth()->user())
            ->withProperties([
                'score_percentage' => $scorePercentage,
                'status' => $status,
                'total_applicable' => $totalApplicable,
                'compliant_answers' => $applicableAnswers->where('is_compliant', true)->count(),
                'system_risk_level' => $systemRiskLevel,
            ])
            ->log("Calcolata percentuale di conformità per Audit #{$audit->id}: {$scorePercentage}% - Stato: {$status}");

        return $audit->fresh();
    }
}
