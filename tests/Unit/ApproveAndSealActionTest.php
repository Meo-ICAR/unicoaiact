<?php

declare(strict_types=1);

use App\Filament\Resources\AiSystems\Actions\ApproveAndSealAction;
use App\Models\AiSystem;
use App\Models\Organization;
use App\Models\PqcSignature;
use App\Models\RiskAssessment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('ApproveAndSealAction aggiorna lo stato a approved, crea il sigillo PQC e registra il log su Spatie ActivityLog', function (): void {
    $user = User::factory()->create(['name' => 'Dr. Marco CTO']);
    $this->actingAs($user);

    $organization = Organization::create([
        'name' => 'Acme Tech',
        'vat_number' => 'IT11223344556',
        'type' => 'company',
    ]);

    $aiSystem = AiSystem::create([
        'organization_id' => $organization->id,
        'name' => 'CRM Copy Generator AI',
        'version' => '1.0.0',
        'owner_id' => $user->id,
        'approval_status' => 'pending_approval',
        'human_oversight_type' => 'human_in_command',
        'has_kill_switch' => true,
    ]);

    $action = ApproveAndSealAction::make();

    // Invoca l'azione custom passando il record e le note
    $action->call([
        'record' => $aiSystem,
        'data' => [
            'approval_notes' => 'Conforme all\'Art. 50 e verificato dal CTO.',
        ],
    ]);

    $aiSystem->refresh();

    expect($aiSystem->approval_status)->toBe('approved');

    // Verifica il sigillo crittografico PQC WORM
    $signature = PqcSignature::where('signable_type', AiSystem::class)
        ->where('signable_id', $aiSystem->id)
        ->first();

    expect($signature)->not->toBeNull();
    expect($signature->hash_algorithm)->toBe('HMAC-SHA3-512');
    expect($signature->data_hash)->not->toBeEmpty();
    expect($signature->pqc_signature)->not->toBeEmpty();

    // Verifica il log su Spatie ActivityLog
    $activity = Activity::where('subject_type', AiSystem::class)
        ->where('subject_id', $aiSystem->id)
        ->latest('id')
        ->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toContain('Sistema IA approvato da Dr. Marco CTO');
});

test('ApproveAndSealAction rifiuta di apporre il sigillo WORM se PQC_WORM_SECRET_KEY non è configurata', function (): void {
    config(['services.pqc_worm.secret' => null]);

    $user = User::factory()->create();
    $this->actingAs($user);

    $organization = Organization::create([
        'name' => 'Acme Tech',
        'vat_number' => 'IT11223344556',
        'type' => 'company',
    ]);

    $aiSystem = AiSystem::create([
        'organization_id' => $organization->id,
        'name' => 'CRM Copy Generator AI',
        'version' => '1.0.0',
        'owner_id' => $user->id,
        'approval_status' => 'pending_approval',
        'human_oversight_type' => 'human_in_command',
        'has_kill_switch' => true,
    ]);

    $action = ApproveAndSealAction::make();

    expect(fn () => $action->call([
        'record' => $aiSystem,
        'data' => ['approval_notes' => null],
    ]))->toThrow(RuntimeException::class);

    expect($aiSystem->refresh()->approval_status)->toBe('pending_approval');
    expect(PqcSignature::count())->toBe(0);
});

test('ApproveAndSealAction rifiuta di approvare un sistema con rischio prohibited', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $organization = Organization::create([
        'name' => 'Acme Tech',
        'vat_number' => 'IT11223344556',
        'type' => 'company',
    ]);

    $aiSystem = AiSystem::create([
        'organization_id' => $organization->id,
        'name' => 'Social Scoring Engine',
        'version' => '1.0.0',
        'owner_id' => $user->id,
        'approval_status' => 'pending_approval',
        'human_oversight_type' => 'human_in_command',
        'has_kill_switch' => true,
    ]);

    RiskAssessment::create([
        'ai_system_id' => $aiSystem->id,
        'risk_level' => 'prohibited',
        'justification' => 'Sistema di social scoring vietato ai sensi dell\'Art. 5.',
        'evaluated_by' => $user->id,
    ]);

    $action = ApproveAndSealAction::make();

    expect(fn () => $action->call([
        'record' => $aiSystem,
        'data' => ['approval_notes' => null],
    ]))->toThrow(RuntimeException::class);

    expect($aiSystem->refresh()->approval_status)->toBe('pending_approval');
    expect(PqcSignature::count())->toBe(0);
});
