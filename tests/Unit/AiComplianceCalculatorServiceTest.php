<?php

declare(strict_types=1);

use App\Models\AiSystem;
use App\Models\Audit;
use App\Models\AuditAnswer;
use App\Models\ComplianceFramework;
use App\Models\FrameworkRequirement;
use App\Models\Organization;
use App\Models\RiskAssessment;
use App\Models\User;
use App\Services\AiComplianceCalculatorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('calcola correttamente la percentuale di conformita e imposta lo stato a compliant quando lo score e maggiore o uguale al 80%', function (): void {
    $user = User::factory()->create();
    $organization = Organization::create([
        'name' => 'Test Org',
        'vat_number' => 'IT12345678901',
        'type' => 'company',
    ]);

    $aiSystem = AiSystem::create([
        'organization_id' => $organization->id,
        'name' => 'HR Recruiting AI',
        'owner_id' => $user->id,
        'approval_status' => 'approved',
    ]);

    RiskAssessment::create([
        'ai_system_id' => $aiSystem->id,
        'risk_level' => 'high',
        'justification' => 'Sistema impiegato nel reclutamento HR ai sensi di Allegato III.',
        'is_annex_iii' => true,
        'evaluated_by' => $user->id,
        'completed_at' => now(),
    ]);

    $framework = ComplianceFramework::create([
        'code' => 'EU_AI_ACT_2024',
        'title' => 'EU AI Act Governance Framework',
        'version' => '1.0',
    ]);

    $req1 = FrameworkRequirement::create([
        'compliance_framework_id' => $framework->id,
        'section_code' => 'Art. 9',
        'title' => 'Gestione dei Rischi',
        'applicable_risk_levels' => ['high'],
    ]);

    $req2 = FrameworkRequirement::create([
        'compliance_framework_id' => $framework->id,
        'section_code' => 'Art. 10',
        'title' => 'Governance dei Dati',
        'applicable_risk_levels' => ['high'],
    ]);

    $req3 = FrameworkRequirement::create([
        'compliance_framework_id' => $framework->id,
        'section_code' => 'Art. 14',
        'title' => 'Sorveglianza Umana',
        'applicable_risk_levels' => ['high'],
    ]);

    $req4 = FrameworkRequirement::create([
        'compliance_framework_id' => $framework->id,
        'section_code' => 'Art. 50',
        'title' => 'Trasparenza Chatbot',
        'applicable_risk_levels' => ['limited'], // Non applicabile al rischio 'high'
    ]);

    $audit = Audit::create([
        'ai_system_id' => $aiSystem->id,
        'compliance_framework_id' => $framework->id,
        'status' => 'draft',
    ]);

    AuditAnswer::create([
        'audit_id' => $audit->id,
        'framework_requirement_id' => $req1->id,
        'is_compliant' => true,
    ]);

    AuditAnswer::create([
        'audit_id' => $audit->id,
        'framework_requirement_id' => $req2->id,
        'is_compliant' => true,
    ]);

    AuditAnswer::create([
        'audit_id' => $audit->id,
        'framework_requirement_id' => $req3->id,
        'is_compliant' => true,
    ]);

    AuditAnswer::create([
        'audit_id' => $audit->id,
        'framework_requirement_id' => $req4->id,
        'is_compliant' => false,
    ]);

    $service = new AiComplianceCalculatorService;
    $updatedAudit = $service->calculate($audit);

    expect((float) $updatedAudit->score_percentage)->toEqual(100.00);
    expect($updatedAudit->status)->toBe('compliant');

    $activity = Activity::where('subject_type', Audit::class)
        ->where('subject_id', $audit->id)
        ->latest('id')
        ->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toContain('100%');
});

test('imposta lo stato a non_compliant quando lo score di conformita e inferiore al 80%', function (): void {
    $user = User::factory()->create();
    $organization = Organization::create([
        'name' => 'Test Org 2',
        'vat_number' => 'IT98765432109',
        'type' => 'company',
    ]);

    $aiSystem = AiSystem::create([
        'organization_id' => $organization->id,
        'name' => 'Biometric Scanner AI',
        'owner_id' => $user->id,
    ]);

    RiskAssessment::create([
        'ai_system_id' => $aiSystem->id,
        'risk_level' => 'high',
        'justification' => 'Sistema di identificazione biometrica.',
        'is_annex_iii' => true,
        'evaluated_by' => $user->id,
    ]);

    $framework = ComplianceFramework::create([
        'code' => 'EU_AI_ACT_2024_ALT',
        'title' => 'EU AI Act Framework',
        'version' => '1.0',
    ]);

    $req1 = FrameworkRequirement::create([
        'compliance_framework_id' => $framework->id,
        'section_code' => 'Art. 9',
        'title' => 'Gestione dei Rischi',
        'applicable_risk_levels' => ['high'],
    ]);

    $req2 = FrameworkRequirement::create([
        'compliance_framework_id' => $framework->id,
        'section_code' => 'Art. 10',
        'title' => 'Governance dei Dati',
        'applicable_risk_levels' => ['high'],
    ]);

    $audit = Audit::create([
        'ai_system_id' => $aiSystem->id,
        'compliance_framework_id' => $framework->id,
        'status' => 'draft',
    ]);

    AuditAnswer::create([
        'audit_id' => $audit->id,
        'framework_requirement_id' => $req1->id,
        'is_compliant' => true,
    ]);

    AuditAnswer::create([
        'audit_id' => $audit->id,
        'framework_requirement_id' => $req2->id,
        'is_compliant' => false,
    ]);

    $service = new AiComplianceCalculatorService;
    $updatedAudit = $service->calculate($audit);

    expect((float) $updatedAudit->score_percentage)->toEqual(50.00);
    expect($updatedAudit->status)->toBe('non_compliant');
});

test('usa la soglia di conformita configurata sul framework invece dell\'80% fisso', function (): void {
    $user = User::factory()->create();
    $organization = Organization::create([
        'name' => 'Test Org 3',
        'vat_number' => 'IT11122233344',
        'type' => 'company',
    ]);

    $aiSystem = AiSystem::create([
        'organization_id' => $organization->id,
        'name' => 'Low Threshold AI',
        'owner_id' => $user->id,
    ]);

    // Framework con soglia di conformità volutamente bassa (40%)
    $framework = ComplianceFramework::create([
        'code' => 'ISO_42001_LOW',
        'title' => 'ISO 42001 Framework',
        'version' => '1.0',
        'compliance_threshold_percentage' => 40,
    ]);

    $req1 = FrameworkRequirement::create([
        'compliance_framework_id' => $framework->id,
        'section_code' => 'C.1',
        'title' => 'Requisito 1',
        'applicable_risk_levels' => [],
    ]);

    $req2 = FrameworkRequirement::create([
        'compliance_framework_id' => $framework->id,
        'section_code' => 'C.2',
        'title' => 'Requisito 2',
        'applicable_risk_levels' => [],
    ]);

    $audit = Audit::create([
        'ai_system_id' => $aiSystem->id,
        'compliance_framework_id' => $framework->id,
        'status' => 'draft',
    ]);

    AuditAnswer::create([
        'audit_id' => $audit->id,
        'framework_requirement_id' => $req1->id,
        'is_compliant' => true,
    ]);

    AuditAnswer::create([
        'audit_id' => $audit->id,
        'framework_requirement_id' => $req2->id,
        'is_compliant' => false,
    ]);

    $service = new AiComplianceCalculatorService;
    $updatedAudit = $service->calculate($audit);

    // 50% >= soglia 40% del framework => compliant, mentre con la soglia fissa dell'80% sarebbe non_compliant
    expect((float) $updatedAudit->score_percentage)->toEqual(50.00);
    expect($updatedAudit->status)->toBe('compliant');
});
