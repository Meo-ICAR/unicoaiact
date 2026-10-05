<?php

declare(strict_types=1);

use App\Filament\Resources\AiSystems\Actions\ApproveAndSealAction;
use App\Models\AiSystem;
use App\Models\Organization;
use App\Models\PqcSignature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;

uses(Tests\TestCase::class, RefreshDatabase::class);

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
    expect($signature->hash_algorithm)->toBe('SHA3-512');
    expect($signature->data_hash)->not->toBeEmpty();
    expect($signature->pqc_signature)->not->toBeEmpty();

    // Verifica il log su Spatie ActivityLog
    $activity = Activity::where('subject_type', AiSystem::class)
        ->where('subject_id', $aiSystem->id)
        ->latest('id')
        ->first();

    expect($activity)->not->toBeNull();
    expect($activity->description)->toContain("Sistema IA approvato da Dr. Marco CTO");
});
