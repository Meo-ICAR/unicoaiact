<?php

namespace Database\Seeders;

use App\Models\Audit;
use App\Models\RiskAssessment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AiComplianceSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // ==========================================
            // 1. ORGANIZZAZIONI (Multi-Tenancy / UnicoConsultant)
            // ==========================================
            $orgAcmeId = DB::table('organizations')->insertGetId([
                'name' => 'ACME Enterprise S.p.A.',
                'vat_number' => 'IT12345678901',
                'type' => 'company',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $orgPaId = DB::table('organizations')->insertGetId([
                'name' => 'Azienda Sanitaria Locale (PA)',
                'vat_number' => 'IT98765432109',
                'type' => 'public_sector',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $orgConsultantId = DB::table('organizations')->insertGetId([
                'name' => 'Unico Compliance Advisory SRL',
                'vat_number' => 'IT55566677788',
                'type' => 'consultant_agency',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ==========================================
            // 2. UTENTI E RUOLI
            // ==========================================
            $complianceOfficer = User::firstOrCreate(
                ['email' => 'officer@acme.com'],
                [
                    'name' => 'Elena Rossi (Chief AI Officer)',
                    'password' => Hash::make('password'),
                ]
            );

            $leadDeveloper = User::firstOrCreate(
                ['email' => 'dev@acme.com'],
                [
                    'name' => 'Marco Bianchi (Lead AI Engineer)',
                    'password' => Hash::make('password'),
                ]
            );

            // ==========================================
            // 3. FRAMEWORK DI COMPLIANCE E REQUISITI
            // ==========================================

            // Framework 1: EU AI Act (Reg. UE 2024/1689)
            $euAiActId = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'EU_AI_ACT_2024',
                'title' => 'EU Artificial Intelligence Act (Regolamento UE 2024/1689)',
                'version' => '1.0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $euAiActReqs = [
                ['section_code' => 'Art. 4', 'title' => 'Alfabetizzazione sull\'IA (AI Literacy)', 'description' => 'Competenze adeguate per il personale sviluppatore e operativo.', 'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high', 'prohibited'])],
                ['section_code' => 'Art. 5', 'title' => 'Pratiche di IA Vietate', 'description' => 'Divieto di tecniche subliminali, social scoring e manipolazione.', 'applicable_risk_levels' => json_encode(['prohibited'])],
                ['section_code' => 'Art. 9', 'title' => 'Sistema di Gestione dei Rischi', 'description' => 'Gestione continua dei rischi lungo tutto il ciclo di vita.', 'applicable_risk_levels' => json_encode(['high'])],
                ['section_code' => 'Art. 10', 'title' => 'Governance dei Dati e dei Dataset', 'description' => 'Qualità dei dati, pertinenza e mitigazione dei bias.', 'applicable_risk_levels' => json_encode(['high'])],
                ['section_code' => 'Art. 11', 'title' => 'Documentazione Tecnica', 'description' => 'Fascicolo tecnico conforme all\'Allegato IV prima del deployment.', 'applicable_risk_levels' => json_encode(['high'])],
                ['section_code' => 'Art. 13', 'title' => 'Trasparenza e Istruzioni d\'Uso', 'description' => 'Fornitura ai deployer di istruzioni chiare su capacità e limiti.', 'applicable_risk_levels' => json_encode(['high'])],
                ['section_code' => 'Art. 14', 'title' => 'Sorveglianza Umana (Human Oversight)', 'description' => 'Presenza di controlli ed estinzione di emergenza (Kill Switch).', 'applicable_risk_levels' => json_encode(['high', 'limited'])],
                ['section_code' => 'Art. 27', 'title' => 'Valutazione d\'Impatto Diritti Fondamentali (FRIA)', 'description' => 'Obbligo FRIA prima dell\'uso di IA ad alto rischio.', 'applicable_risk_levels' => json_encode(['high'])],
                ['section_code' => 'Art. 50', 'title' => 'Obblighi Trasparenza IA Generativa', 'description' => 'Marcatura trasparente di contenuti sintetici e chatbot.', 'applicable_risk_levels' => json_encode(['limited', 'high'])],
            ];

            foreach ($euAiActReqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, ['compliance_framework_id' => $euAiActId, 'created_at' => now(), 'updated_at' => now()]));
            }

            // Framework 2: ISO/IEC 42001:2023
            $isoId = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'ISO_IEC_42001_2023',
                'title' => 'ISO/IEC 42001:2023 - Artificial Intelligence Management System',
                'version' => '2023',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $isoReqs = [
                ['section_code' => 'Control A.5', 'title' => 'Politiche per l\'IA', 'description' => 'Linee guida etiche aziendali.', 'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high'])],
                ['section_code' => 'Control A.8', 'title' => 'Gestione Fornitori API IA', 'description' => 'Audit dei fornitori terzi di modelli LLM.', 'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high'])],
            ];

            foreach ($isoReqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, ['compliance_framework_id' => $isoId, 'created_at' => now(), 'updated_at' => now()]));
            }

            // Framework 3: GDPR
            $gdprId = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'GDPR_2016_679',
                'title' => 'Regolamento Generale Protezione Dati (GDPR)',
                'version' => '2016/679',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $gdprReqs = [
                ['section_code' => 'Art. 22', 'title' => 'Profilazione ed Alogritmi Automatizzati', 'description' => 'Diritto all\'intervento umano nelle decisioni automatizzate.', 'applicable_risk_levels' => json_encode(['high'])],
                ['section_code' => 'Art. 35', 'title' => 'DPIA (Valutazione Impatto)', 'description' => 'Valutazione impatto privacy per trattamenti ad alto rischio.', 'applicable_risk_levels' => json_encode(['high'])],
            ];

            foreach ($gdprReqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, ['compliance_framework_id' => $gdprId, 'created_at' => now(), 'updated_at' => now()]));
            }

            // ==========================================
            // 4. MODELLI IA UTILIZZATI
            // ==========================================
            $gpt4oId = DB::table('ai_models')->insertGetId([
                'name' => 'GPT-4o API',
                'provider' => 'OpenAI',
                'hosting_type' => 'SaaS Cloud',
                'is_third_party' => true,
                'created_at' => now(), 'updated_at' => now(),
            ]);

            $claudeId = DB::table('ai_models')->insertGetId([
                'name' => 'Claude 3.5 Sonnet',
                'provider' => 'Anthropic',
                'hosting_type' => 'AWS Bedrock EU',
                'is_third_party' => true,
                'created_at' => now(), 'updated_at' => now(),
            ]);

            $xgboostId = DB::table('ai_models')->insertGetId([
                'name' => 'CreditScore-XGBoost-v2',
                'provider' => 'In-House Data Science',
                'hosting_type' => 'On-Premise Private Cloud',
                'is_third_party' => false,
                'created_at' => now(), 'updated_at' => now(),
            ]);

            // ==========================================
            // 5. SISTEMI IA CRM & GOVERNANCE
            // ==========================================

            // Sistema 1: CRM Smart Email Assistant (Rischio Limitato)
            $system1Id = DB::table('ai_systems')->insertGetId([
                'organization_id' => $orgAcmeId,
                'name' => 'CRM AI Smart Assistant (Email & Note)',
                'description' => 'Modulo CRM per generazione bozze email e trascrizione telefonate.',
                'version' => '2.1.0',
                'owner_id' => $leadDeveloper->id,
                'is_shadow_ai' => false,
                'approval_status' => 'approved',
                'human_oversight_type' => 'human_in_the_loop',
                'has_kill_switch' => true,
                'kill_switch_procedure' => 'Disabilitazione immediata via toggle feature flag API in dashboard admin.',
                'eu_registration_status' => 'not_required',
                'created_at' => now(), 'updated_at' => now(),
            ]);
            DB::table('ai_system_model')->insert([
                ['ai_system_id' => $system1Id, 'ai_model_id' => $gpt4oId],
                ['ai_system_id' => $system1Id, 'ai_model_id' => $claudeId],
            ]);

            // Sistema 2: CRM Scoring Creditizio Clienti (Alto Rischio)
            $system2Id = DB::table('ai_systems')->insertGetId([
                'organization_id' => $orgAcmeId,
                'name' => 'CRM Credit Risk & Credit Scoring Engine',
                'description' => 'Modulo per la valutazione automatica della solvibilità fidi clienti B2B.',
                'version' => '1.0.4',
                'owner_id' => $complianceOfficer->id,
                'is_shadow_ai' => false,
                'approval_status' => 'pending_approval',
                'human_oversight_type' => 'human_on_the_loop',
                'has_kill_switch' => true,
                'kill_switch_procedure' => 'Reindirizzamento immediato delle richieste di scoring al comitato fidi manuale.',
                'eu_db_registration_id' => 'EU-AIR-2026-88492',
                'eu_registration_status' => 'pending',
                'created_at' => now(), 'updated_at' => now(),
            ]);
            DB::table('ai_system_model')->insert([
                ['ai_system_id' => $system2Id, 'ai_model_id' => $xgboostId],
            ]);

            // Sistema 3: Rilevato come Shadow AI (Recruitment HR)
            $system3Id = DB::table('ai_systems')->insertGetId([
                'organization_id' => $orgAcmeId,
                'name' => 'Unapproved Talent Screening Tool',
                'description' => 'Estensione browser usata dal team HR per lo screening automatico CV da LinkedIn.',
                'version' => '0.9.0',
                'owner_id' => $leadDeveloper->id,
                'is_shadow_ai' => true,
                'discovery_method' => 'Automated CASB Network Scanner',
                'approval_status' => 'rejected',
                'human_oversight_type' => null,
                'has_kill_switch' => false,
                'eu_registration_status' => 'not_required',
                'created_at' => now(), 'updated_at' => now(),
            ]);

            // ==========================================
            // 6. RISC ASSESSMENTS
            // ==========================================
            $risk1Id = DB::table('risk_assessments')->insertGetId([
                'ai_system_id' => $system1Id,
                'risk_level' => 'limited',
                'justification' => 'Genera testo (e-mail). Rientra nell\'Articolo 50 per gli obblighi di trasparenza visiva.',
                'is_annex_iii' => false,
                'evaluated_by' => $complianceOfficer->id,
                'completed_at' => now()->subDays(10),
                'created_at' => now()->subDays(10), 'updated_at' => now()->subDays(10),
            ]);

            $risk2Id = DB::table('risk_assessments')->insertGetId([
                'ai_system_id' => $system2Id,
                'risk_level' => 'high',
                'justification' => 'Allegato III Punto 5: Valutazione del merito creditizio. Richiede conformità rigorosa e FRIA.',
                'is_annex_iii' => true,
                'evaluated_by' => $complianceOfficer->id,
                'completed_at' => now()->subDays(5),
                'created_at' => now()->subDays(5), 'updated_at' => now()->subDays(5),
            ]);

            // ==========================================
            // 7. FRIA (VALUTAZIONE D'IMPATTO DIRITTI FONDAMENTALI)
            // ==========================================
            DB::table('fria_assessments')->insert([
                'ai_system_id' => $system2Id,
                'gdpr_dpia_id' => 101, // ID ipotetico UnicoGDPR
                'affected_categories' => 'Clienti B2B, Piccole Imprese, Garanti personali.',
                'fundamental_rights_impact' => 'Impatto potenziale sul diritto di impresa e non discriminazione economica.',
                'mitigation_measures' => 'Presenza obbligatoria di revisione umana prima del rifiuto definitivo del credito.',
                'assessed_by' => $complianceOfficer->id,
                'completed_at' => now()->subDays(2),
                'created_at' => now()->subDays(2), 'updated_at' => now()->subDays(2),
            ]);

            // ==========================================
            // 8. BIAS TESTING & DRIFT MONITORING
            // ==========================================
            DB::table('bias_tests')->insert([
                [
                    'ai_system_id' => $system2Id,
                    'test_name' => 'Q2 2026 Gender & Region Bias Test',
                    'fairness_score' => 96.50,
                    'drift_score' => 1.20,
                    'passed' => true,
                    'metrics_payload' => json_encode(['disparate_impact_ratio' => 0.98, 'sample_size' => 45000]),
                    'tested_at' => now()->subDays(3),
                    'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'ai_system_id' => $system3Id,
                    'test_name' => 'Shadow AI Age Discrimination Check',
                    'fairness_score' => 64.00,
                    'drift_score' => 14.50,
                    'passed' => false,
                    'metrics_payload' => json_encode(['alert' => 'Rilevata discriminazione sfavorevole per candidati over 50']),
                    'tested_at' => now()->subDays(1),
                    'created_at' => now(), 'updated_at' => now(),
                ],
            ]);

            // ==========================================
            // 9. METRICHE ESG (UnicoESG Integration)
            // ==========================================
            DB::table('esg_ai_metrics')->insert([
                [
                    'ai_system_id' => $system1Id,
                    'estimated_kwh_consumption' => 420.50,
                    'carbon_footprint_kg' => 115.30,
                    'ethical_governance_score' => 92.00,
                    'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'ai_system_id' => $system2Id,
                    'estimated_kwh_consumption' => 1250.00,
                    'carbon_footprint_kg' => 340.00,
                    'ethical_governance_score' => 78.50,
                    'created_at' => now(), 'updated_at' => now(),
                ],
            ]);

            // ==========================================
            // 10. AUDIT & AUDIT ANSWERS
            // ==========================================
            $audit1Id = DB::table('audits')->insertGetId([
                'ai_system_id' => $system1Id,
                'compliance_framework_id' => $euAiActId,
                'status' => 'compliant',
                'score_percentage' => 100.00,
                'created_at' => now()->subDays(7), 'updated_at' => now(),
            ]);

            $art50Req = DB::table('framework_requirements')->where('compliance_framework_id', $euAiActId)->where('section_code', 'Art. 50')->first();

            DB::table('audit_answers')->insert([
                'audit_id' => $audit1Id,
                'framework_requirement_id' => $art50Req->id,
                'is_compliant' => true,
                'notes' => 'Aggiunto badge visibile "Generato da IA" su ogni bozza e-mail generata.',
                'payload' => json_encode(['ui_component' => 'AiBadge.vue']),
                'created_at' => now(), 'updated_at' => now(),
            ]);

            // ==========================================
            // 11. SIGILLI CRITTOGRAFICI POST-QUANTISTICI (UnicoPQC)
            // ==========================================
            DB::table('pqc_signatures')->insert([
                [
                    'signable_type' => Audit::class,
                    'signable_id' => $audit1Id,
                    'hash_algorithm' => 'SHA3-512',
                    'data_hash' => hash('sha3-512', 'AUDIT_RESULT_FULL_PAYLOAD_100_PERCENT'),
                    'pqc_signature' => 'PQC-CRYPTO-DILITHIUM5-SIG-88392019384729103847291038472910384729103847291038472910',
                    'sealed_at' => now()->subDays(7),
                    'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'signable_type' => RiskAssessment::class,
                    'signable_id' => $risk2Id,
                    'hash_algorithm' => 'SHA3-512',
                    'data_hash' => hash('sha3-512', 'RISK_ASSESSMENT_HIGH_RISK_CREDIT_ENGINE'),
                    'pqc_signature' => 'PQC-CRYPTO-FALCON1024-SIG-99182371928371928371928371928371928371928371928371928371',
                    'sealed_at' => now()->subDays(5),
                    'created_at' => now(), 'updated_at' => now(),
                ],
            ]);

            // ==========================================
            // 12. INCIDENTI & NOTIFICA AUTORITÀ
            // ==========================================
            DB::table('ai_incidents')->insert([
                [
                    'ai_system_id' => $system1Id,
                    'incident_type' => 'Hallucination in Commercial Email',
                    'description' => 'Generazione automatica di uno sconto del 50% non previsto nel testo mail.',
                    'severity' => 'medium',
                    'reported_to_authority' => false,
                    'authority_notified_at' => null,
                    'authority_reference_code' => null,
                    'reported_at' => now()->subDays(10),
                    'resolved_at' => now()->subDays(9),
                    'created_at' => now()->subDays(10), 'updated_at' => now()->subDays(9),
                ],
                [
                    'ai_system_id' => $system2Id,
                    'incident_type' => 'Systemic Bias Breach',
                    'description' => 'Anomalia nel calcolo fidi per aziende neocostituite con blocco ingiustificato.',
                    'severity' => 'critical',
                    'reported_to_authority' => true,
                    'authority_notified_at' => now()->subDays(1),
                    'authority_reference_code' => 'AGID-INC-2026-00492',
                    'reported_at' => now()->subDays(2),
                    'resolved_at' => null,
                    'created_at' => now()->subDays(2), 'updated_at' => now()->subDays(1),
                ],
            ]);

        });
    }
}
