<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AiIncident;
use App\Models\AiModel;
use App\Models\AiSystem;
use App\Models\Audit;
use App\Models\AuditAnswer;
use App\Models\ComplianceFramework;
use App\Models\FrameworkRequirement;
use App\Models\Organization;
use App\Models\RiskAssessment;
use App\Models\User;
use App\Services\AiComplianceCalculatorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ComplianceDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            // 1. Organizzazione e Utenti di Riferimento
            $organization = Organization::firstOrCreate(
                ['vat_number' => 'IT99887766554'],
                [
                    'name' => 'Unico Corporate Group S.p.A.',
                    'type' => 'company',
                ]
            );

            $owner = User::firstOrCreate(
                ['email' => 'governance.lead@unico-corporate.it'],
                [
                    'name' => 'Dott. Valerio Neri (Chief AI Governance Officer)',
                    'password' => Hash::make('password'),
                ]
            );

            $evaluator = User::firstOrCreate(
                ['email' => 'auditor@unico-corporate.it'],
                [
                    'name' => 'Ing. Sofia Moretti (Lead Compliance Auditor)',
                    'password' => Hash::make('password'),
                ]
            );

            // 2. Framework EU AI Act & Requisiti
            $framework = ComplianceFramework::firstOrCreate(
                ['code' => 'EU_AI_ACT_2024'],
                [
                    'title' => 'EU Artificial Intelligence Act (Regolamento UE 2024/1689)',
                    'version' => '1.0',
                ]
            );

            $reqArt4 = FrameworkRequirement::firstOrCreate(
                [
                    'compliance_framework_id' => $framework->id,
                    'section_code' => 'Art. 4',
                ],
                [
                    'title' => 'Alfabetizzazione sull\'IA (AI Literacy)',
                    'description' => 'Misure volte a garantire un livello sufficiente di alfabetizzazione sull\'IA per il personale e i responsabili operativo-gestionali.',
                    'applicable_risk_levels' => ['minimal', 'limited', 'high', 'prohibited'],
                ]
            );

            $reqArt10 = FrameworkRequirement::firstOrCreate(
                [
                    'compliance_framework_id' => $framework->id,
                    'section_code' => 'Art. 10',
                ],
                [
                    'title' => 'Governance dei Dati e dei Dataset',
                    'description' => 'Requisiti di qualità dei dati di addestramento, validazione e test, assenza di bias e corretta rappresentatività.',
                    'applicable_risk_levels' => ['high'],
                ]
            );

            $reqArt14 = FrameworkRequirement::firstOrCreate(
                [
                    'compliance_framework_id' => $framework->id,
                    'section_code' => 'Art. 14',
                ],
                [
                    'title' => 'Sorveglianza Umana (Human Oversight)',
                    'description' => 'Presenza di interfacce umane per prevenire o ridurre i rischi, comprese funzionalità di override e kill switch.',
                    'applicable_risk_levels' => ['high', 'limited'],
                ]
            );

            $reqArt50 = FrameworkRequirement::firstOrCreate(
                [
                    'compliance_framework_id' => $framework->id,
                    'section_code' => 'Art. 50',
                ],
                [
                    'title' => 'Trasparenza per Sistemi di IA Generativa',
                    'description' => 'Trasparenza ed etichettatura per l\'interazione con utenti umani e marcatura di contenuti sintetici (watermarking).',
                    'applicable_risk_levels' => ['limited', 'high'],
                ]
            );

            // 3. Modelli IA Utilizzati
            $modelGpt4o = AiModel::firstOrCreate(
                ['name' => 'GPT-4o'],
                [
                    'provider' => 'OpenAI',
                    'hosting_type' => 'SaaS API',
                    'is_third_party' => true,
                ]
            );

            $modelClaude = AiModel::firstOrCreate(
                ['name' => 'Claude 3.5 Sonnet'],
                [
                    'provider' => 'Anthropic',
                    'hosting_type' => 'SaaS API',
                    'is_third_party' => true,
                ]
            );

            $modelLlama = AiModel::firstOrCreate(
                ['name' => 'Llama 3 70B Instruct'],
                [
                    'provider' => 'Meta / Internal Hosting',
                    'hosting_type' => 'Private Cloud',
                    'is_third_party' => false,
                ]
            );

            $modelScikit = AiModel::firstOrCreate(
                ['name' => 'XGBoost Credit Classifier v2.1'],
                [
                    'provider' => 'Internal ML Team',
                    'hosting_type' => 'On-Premise',
                    'is_third_party' => false,
                ]
            );

            $modelDeepface = AiModel::firstOrCreate(
                ['name' => 'DeepFace Biometric Recog v4'],
                [
                    'provider' => 'VisionTech Third Party',
                    'hosting_type' => 'On-Premise Edge',
                    'is_third_party' => true,
                ]
            );

            $calculator = new AiComplianceCalculatorService();

            // 4. Definizione dei 5 Sistemi IA e relativi dati correlati

            // SYSTEM 1: RAG Customer Support
            $system1 = AiSystem::create([
                'organization_id' => $organization->id,
                'name' => 'RAG Customer Support Agent',
                'description' => 'Assistente virtuale intelligente basato su architettura RAG per supporto clienti e consultazione knowledge base.',
                'version' => '2.1.0',
                'owner_id' => $owner->id,
                'is_shadow_ai' => false,
                'discovery_method' => 'Registro Architettura Aziendale',
                'approval_status' => 'approved',
                'human_oversight_type' => 'human_on_the_loop',
                'has_kill_switch' => true,
                'kill_switch_procedure' => 'Disattivazione immediata dell\'endpoint API e reindirizzamento delle chat ad operatori umani.',
                'eu_db_registration_id' => 'EU-DB-2026-RAG-9021',
                'eu_registration_status' => 'registered',
            ]);
            $system1->aiModels()->sync([$modelGpt4o->id, $modelClaude->id]);

            RiskAssessment::create([
                'ai_system_id' => $system1->id,
                'risk_level' => 'limited',
                'justification' => 'Sistema destinato all\'interazione con persone fisiche e alla generazione di testo ai sensi dell\'Art. 50 (Rischio Limitato). Obbligo di informare chiaramente l\'utente finale di interagire con un sistema di IA.',
                'is_annex_iii' => false,
                'evaluated_by' => $evaluator->id,
                'completed_at' => now()->subDays(20),
            ]);

            $audit1 = Audit::create([
                'ai_system_id' => $system1->id,
                'compliance_framework_id' => $framework->id,
                'status' => 'in_review',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit1->id,
                'framework_requirement_id' => $reqArt4->id,
                'is_compliant' => true,
                'notes' => 'Tutti gli operatori di supporto sono stati formati sull\'uso dell\'assistente RAG e le relative limitazioni.',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit1->id,
                'framework_requirement_id' => $reqArt14->id,
                'is_compliant' => true,
                'notes' => 'Presente pulsante di escalation operatore umano in qualsiasi momento.',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit1->id,
                'framework_requirement_id' => $reqArt50->id,
                'is_compliant' => true,
                'notes' => 'Disclaimer visibile nella finestra di chat che avvisa l\'utente della natura sintetica dell\'interlocutore.',
            ]);

            $calculator->calculate($audit1);

            // SYSTEM 2: Predictive Credit Score Engine
            $system2 = AiSystem::create([
                'organization_id' => $organization->id,
                'name' => 'Predictive Credit Score Engine',
                'description' => 'Modello predittivo per la valutazione del merito creditizio ed esame delle richieste di prestito per privati ed imprese.',
                'version' => '1.4.0',
                'owner_id' => $owner->id,
                'is_shadow_ai' => false,
                'discovery_method' => 'Valutazione Risk Committee',
                'approval_status' => 'approved',
                'human_oversight_type' => 'human_in_the_loop',
                'has_kill_switch' => true,
                'kill_switch_procedure' => 'Fallback automatico su scorecard tradizionale senza componenti ML in caso di anomalie di scoring.',
                'eu_db_registration_id' => 'EU-DB-2026-CRED-4410',
                'eu_registration_status' => 'registered',
            ]);
            $system2->aiModels()->sync([$modelScikit->id]);

            RiskAssessment::create([
                'ai_system_id' => $system2->id,
                'risk_level' => 'high',
                'justification' => 'Rientra espressamente nell\'Allegato III, punto 5(b) dell\'EU AI Act: Sistemi di IA destinati ad essere utilizzati per valutare il merito creditizio di persone fisiche. Prescritti adempimenti di conformità e FRIA.',
                'is_annex_iii' => true,
                'evaluated_by' => $evaluator->id,
                'completed_at' => now()->subDays(15),
            ]);

            $audit2 = Audit::create([
                'ai_system_id' => $system2->id,
                'compliance_framework_id' => $framework->id,
                'status' => 'in_review',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit2->id,
                'framework_requirement_id' => $reqArt4->id,
                'is_compliant' => true,
                'notes' => 'Formazione accreditata svolta per gli analisti del credito.',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit2->id,
                'framework_requirement_id' => $reqArt10->id,
                'is_compliant' => true,
                'notes' => 'Dataset verificato su disparità di genere e geografiche con report di assenza di bias.',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit2->id,
                'framework_requirement_id' => $reqArt14->id,
                'is_compliant' => true,
                'notes' => 'Ogni delibera automatica sotto una certa soglia deve essere confermata da un funzionario del credito.',
            ]);

            $calculator->calculate($audit2);

            // Registro incidenti per Credit Engine
            AiIncident::create([
                'ai_system_id' => $system2->id,
                'incident_type' => 'Bias / Anomalia di Scoring',
                'description' => 'Rilevata temporanea deviazione di punteggio per la categoria dei giovani lavoratori autonomi a seguito di aggiornamento dei coefficienti macroeconomici.',
                'severity' => 'medium',
                'reported_to_authority' => true,
                'authority_notified_at' => now()->subDays(5),
                'authority_reference_code' => 'NOT-AGID-2026-0812',
                'reported_at' => now()->subDays(6),
                'resolved_at' => now()->subDays(2),
            ]);

            // SYSTEM 3: HR Resume Matcher
            $system3 = AiSystem::create([
                'organization_id' => $organization->id,
                'name' => 'HR Resume Matcher & Profiler',
                'description' => 'Sistema di screening automatico di curriculum vitae e ranking dei candidati per posizioni aperte aziendali.',
                'version' => '3.0.1',
                'owner_id' => $owner->id,
                'is_shadow_ai' => false,
                'discovery_method' => 'Audit Risorse Umane',
                'approval_status' => 'approved',
                'human_oversight_type' => 'human_in_the_loop',
                'has_kill_switch' => true,
                'kill_switch_procedure' => 'Disattivazione dello staccamento automatico e ripristino vaglio manuale integrale dei CV.',
                'eu_db_registration_id' => 'EU-DB-2026-HR-1189',
                'eu_registration_status' => 'pending',
            ]);
            $system3->aiModels()->sync([$modelClaude->id, $modelLlama->id]);

            RiskAssessment::create([
                'ai_system_id' => $system3->id,
                'risk_level' => 'high',
                'justification' => 'Incluso nell\'Allegato III, punto 4(a) dell\'EU AI Act: Sistemi di IA destinati ad essere utilizzati per il reclutamento o la selezione di persone fisiche, in particolare per la vagliatura e la selezione di candidature.',
                'is_annex_iii' => true,
                'evaluated_by' => $evaluator->id,
                'completed_at' => now()->subDays(10),
            ]);

            $audit3 = Audit::create([
                'ai_system_id' => $system3->id,
                'compliance_framework_id' => $framework->id,
                'status' => 'in_review',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit3->id,
                'framework_requirement_id' => $reqArt4->id,
                'is_compliant' => true,
                'notes' => 'Team Talent Acquisition addestrato sulle linee guida etiche per la selezione.',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit3->id,
                'framework_requirement_id' => $reqArt10->id,
                'is_compliant' => false,
                'notes' => 'Necessario approfondire il test di robustezza su dataset di CV non convenzionali.',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit3->id,
                'framework_requirement_id' => $reqArt14->id,
                'is_compliant' => true,
                'notes' => 'Nessun candidato viene scartato senza previa revisione ed approvazione espressa del recruiter umano.',
            ]);

            $calculator->calculate($audit3);

            // Incidente per HR System
            AiIncident::create([
                'ai_system_id' => $system3->id,
                'incident_type' => 'Disparità di Trattamento / Algorithmic Misrank',
                'description' => 'Falso negativo nell\'estrazione di competenze tecniche per candidati con titoli esteri non standardizzati.',
                'severity' => 'high',
                'reported_to_authority' => false,
                'reported_at' => now()->subDays(3),
            ]);

            // SYSTEM 4: Marketing Email Generator
            $system4 = AiSystem::create([
                'organization_id' => $organization->id,
                'name' => 'Marketing Email & Copy Generator',
                'description' => 'Piattaforma di generazione bozze di newsletter e contenuti social aziendali.',
                'version' => '1.0.0',
                'owner_id' => $owner->id,
                'is_shadow_ai' => false,
                'discovery_method' => 'Self-service Marketing Team',
                'approval_status' => 'approved',
                'human_oversight_type' => 'human_in_command',
                'has_kill_switch' => false,
                'eu_registration_status' => 'not_required',
            ]);
            $system4->aiModels()->sync([$modelGpt4o->id]);

            RiskAssessment::create([
                'ai_system_id' => $system4->id,
                'risk_level' => 'minimal',
                'justification' => 'Sistema adibito alla redazione di bozze ad uso interno per campagne commerciali senza impatto sui diritti fondamentali né obblighi di trasparenza verso l\'esterno.',
                'is_annex_iii' => false,
                'evaluated_by' => $evaluator->id,
                'completed_at' => now()->subDays(40),
            ]);

            $audit4 = Audit::create([
                'ai_system_id' => $system4->id,
                'compliance_framework_id' => $framework->id,
                'status' => 'in_review',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit4->id,
                'framework_requirement_id' => $reqArt4->id,
                'is_compliant' => true,
                'notes' => 'Linee guida di copy-checking approvate ed operative.',
            ]);

            $calculator->calculate($audit4);

            // SYSTEM 5: Biometric Access System
            $system5 = AiSystem::create([
                'organization_id' => $organization->id,
                'name' => 'Biometric Access Control System',
                'description' => 'Sistema di riconoscimento facciale per l\'accesso a varchi riservati e zone ad alta sicurezza.',
                'version' => '4.2.0',
                'owner_id' => $owner->id,
                'is_shadow_ai' => false,
                'discovery_method' => 'Audit Security & Premises',
                'approval_status' => 'pending_approval',
                'human_oversight_type' => 'human_in_the_loop',
                'has_kill_switch' => true,
                'kill_switch_procedure' => 'Attivazione immediata del sistema badge fisico tradizionale e disabilitazione telecamere di varco.',
                'eu_db_registration_id' => 'EU-DB-2026-BIO-0099',
                'eu_registration_status' => 'pending',
            ]);
            $system5->aiModels()->sync([$modelDeepface->id]);

            RiskAssessment::create([
                'ai_system_id' => $system5->id,
                'risk_level' => 'high',
                'justification' => 'Classificato ai sensi dell\'Allegato III, punto 1: Identificazione biometrica remota e categorizzazione di persone fisiche. Soggetto a DPIA GDPR coordinata e rigorosi controlli di sorveglianza umana.',
                'is_annex_iii' => true,
                'evaluated_by' => $evaluator->id,
                'completed_at' => now()->subDays(5),
            ]);

            $audit5 = Audit::create([
                'ai_system_id' => $system5->id,
                'compliance_framework_id' => $framework->id,
                'status' => 'in_review',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit5->id,
                'framework_requirement_id' => $reqArt4->id,
                'is_compliant' => true,
                'notes' => 'Operatori di vigilanza debitamente formati.',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit5->id,
                'framework_requirement_id' => $reqArt10->id,
                'is_compliant' => true,
                'notes' => 'Vettori biometrici crittografati senza memorizzazione di immagini grezze.',
            ]);

            AuditAnswer::create([
                'audit_id' => $audit5->id,
                'framework_requirement_id' => $reqArt14->id,
                'is_compliant' => true,
                'notes' => 'Presidio costante con guardia giurata ai varchi abilitata al controllo manuale.',
            ]);

            $calculator->calculate($audit5);

            // Incidente per Biometric System
            AiIncident::create([
                'ai_system_id' => $system5->id,
                'incident_type' => 'Falso Rifiuto di Riconoscimento',
                'description' => 'Mancato riconoscimento dovuto a variazione d\'illuminazione straordinaria nel varco nord.',
                'severity' => 'low',
                'reported_to_authority' => false,
                'reported_at' => now()->subDays(1),
            ]);
        });
    }
}
