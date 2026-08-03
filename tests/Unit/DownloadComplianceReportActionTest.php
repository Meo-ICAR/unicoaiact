<?php

declare(strict_types=1);

use App\Filament\Resources\AiSystems\Actions\DownloadComplianceReportAction;
use App\Models\AiModel;
use App\Models\AiSystem;
use App\Models\Organization;
use App\Models\RiskAssessment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\StreamedResponse;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('DownloadComplianceReportAction genera e scarica il PDF del kit cliente di conformita', function (): void {
    $user = User::factory()->create(['name' => 'Dr. Audit Lead']);
    $this->actingAs($user);

    $organization = Organization::create([
        'name' => 'Unico Corporate Group',
        'vat_number' => 'IT99887766554',
        'type' => 'company',
    ]);

    $aiSystem = AiSystem::create([
        'organization_id' => $organization->id,
        'name' => 'RAG Customer Support Agent',
        'version' => '2.1.0',
        'owner_id' => $user->id,
        'approval_status' => 'approved',
        'human_oversight_type' => 'human_on_the_loop',
        'has_kill_switch' => true,
        'kill_switch_procedure' => 'Disattivazione immediata endpoint API.',
    ]);

    $model = AiModel::create([
        'name' => 'GPT-4o',
        'provider' => 'OpenAI',
        'hosting_type' => 'SaaS API',
        'is_third_party' => true,
    ]);
    $aiSystem->aiModels()->attach($model->id);

    RiskAssessment::create([
        'ai_system_id' => $aiSystem->id,
        'risk_level' => 'limited',
        'justification' => 'Sistema con obblighi di trasparenza ai sensi dell\'Art. 50.',
        'is_annex_iii' => false,
        'evaluated_by' => $user->id,
    ]);

    $action = DownloadComplianceReportAction::make();

    $response = $action->call(['record' => $aiSystem]);

    expect($response)->toBeInstanceOf(StreamedResponse::class);
});
