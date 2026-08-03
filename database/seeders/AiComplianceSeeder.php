<?php

namespace Database\Seeders;

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
            // 1. UTENTI E RUOLI DI PROVA
            // ==========================================
            $complianceOfficer = User::firstOrCreate(
                ['email' => 'officer@company.com'],
                [
                    'name' => 'Elena Rossi (AI Compliance Officer)',
                    'password' => Hash::make('password'),
                ]
            );

            $leadDeveloper = User::firstOrCreate(
                ['email' => 'dev@company.com'],
                [
                    'name' => 'Marco Bianchi (Lead AI Engineer)',
                    'password' => Hash::make('password'),
                ]
            );

            // ==========================================
            // 2. FRAMEWORK DI COMPLIANCE E REQUISITI
            // ==========================================

            // A. EU AI ACT (2024/1689)
            $euAiActId = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'EU_AI_ACT_2024',
                'title' => 'EU Artificial Intelligence Act (Regolamento UE 2024/1689)',
                'version' => '1.0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $euAiActReqs = [
                [
                    'section_code' => 'Art. 4',
                    'title' => 'Alfabetizzazione sull\'IA (AI Literacy)',
                    'description' => 'I fornitori e distributori garantiscono un livello di competenze adeguato per il personale operativo ed enginnering.',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high', 'prohibited']),
                ],
                [
                    'section_code' => 'Art. 5',
                    'title' => 'Pratiche di IA Vietate',
                    'description' => 'Verifica dell\'assenza di tecniche subliminali, social scoring o identificazione biometrica remota vietata.',
                    'applicable_risk_levels' => json_encode(['prohibited']),
                ],
                [
                    'section_code' => 'Art. 9',
                    'title' => 'Sistema di Gestione dei Rischi',
                    'description' => 'Gestione continua, iterativa e documentata dei rischi per tutto il ciclo di vita del sistema.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 10',
                    'title' => 'Governance dei Dati e dei Dataset',
                    'description' => 'Dataset di addestramento e test pertinenti, privi di bias sistemici e conformi alla qualità richiesta.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 11',
                    'title' => 'Documentazione Tecnica',
                    'description' => 'Redazione della documentazione tecnica dettagliata prima della commercializzazione (Allegato IV).',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 12',
                    'title' => 'Registrazione degli Eventi (Logging)',
                    'description' => 'Capacità di tracciamento e logging automatico degli eventi di funzionamento del sistema.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 13',
                    'title' => 'Trasparenza e Istruzioni d\'Uso',
                    'description' => 'Fornitura ai deployer/clienti di istruzioni chiare su capacità, limitazioni e tasso di errore.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 14',
                    'title' => 'Sorveglianza Umana (Human-in-the-loop)',
                    'description' => 'Interfacce che permettono all\'utente umano di intervenire, annullare o sovrascrivere l\'esito dell\'IA.',
                    'applicable_risk_levels' => json_encode(['high', 'limited']),
                ],
                [
                    'section_code' => 'Art. 15',
                    'title' => 'Accuratezza, Robustezza e Cybersecurity',
                    'description' => 'Resilienza del sistema contro attacchi informatici (prompt injection, poisoning) ed errori.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 27',
                    'title' => 'Valutazione di Impatto sui Diritti Fondamentali (FRIA)',
                    'description' => 'Valutazione dell\'impatto sui diritti fondamentali prima della messa in servizio per i sistemi ad alto rischio.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 50',
                    'title' => 'Obblighi di Trasparenza IA Generativa',
                    'description' => 'Notifica trasparente e visibile agli utenti che stanno interagendo con un\'IA o fruendo di contenuti sintetici.',
                    'applicable_risk_levels' => json_encode(['limited', 'high']),
                ],
            ];

            foreach ($euAiActReqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, [
                    'compliance_framework_id' => $euAiActId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            // B. ISO/IEC 42001:2023
            $isoId = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'ISO_IEC_42001_2023',
                'title' => 'ISO/IEC 42001:2023 - Artificial Intelligence Management System',
                'version' => '2023',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $isoReqs = [
                [
                    'section_code' => 'Control A.5',
                    'title' => 'Politiche aziendali per l\'IA',
                    'description' => 'Definizione formale delle linee guida sull\'uso responsabile ed etico dell\'IA in azienda.',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high']),
                ],
                [
                    'section_code' => 'Control A.6',
                    'title' => 'Gestione delle Risorse Dati',
                    'description' => 'Tracciabilità e governance della provenienza dei dati usati nei prompt e nel fine-tuning.',
                    'applicable_risk_levels' => json_encode(['limited', 'high']),
                ],
                [
                    'section_code' => 'Control A.8',
                    'title' => 'Valutazione Fornitori e API Terze',
                    'description' => 'Verifica della sicurezza e SLA dei provider esterni di modelli IA (OpenAI, Anthropic, ecc.).',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high']),
                ],
            ];

            foreach ($isoReqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, [
                    'compliance_framework_id' => $isoId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            // C. GDPR (Focus IA & Profilazione)
            $gdprId = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'GDPR_2016_679',
                'title' => 'Regolamento Generale sulla Protezione dei Dati (GDPR)',
                'version' => '2016/679',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $gdprReqs = [
                [
                    'section_code' => 'Art. 6 & 9',
                    'title' => 'Base Giuridica e Dati Particolari',
                    'description' => 'Verifica delle basi legali per l\'invio di dati personali di clienti/lead alle API di IA.',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high']),
                ],
                [
                    'section_code' => 'Art. 22',
                    'title' => 'Decisioni Automatizzate e Profilazione',
                    'description' => 'Diritto dell\'interessato di non essere sottoposto a decisioni unicamente automatizzate senza intervento umano.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 35',
                    'title' => 'DPIA (Valutazione Impatto Privacy)',
                    'description' => 'Svolgimento di una DPIA formale prima del deployment di algoritmi di profilazione o valutazione.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
            ];

            foreach ($gdprReqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, [
                    'compliance_framework_id' => $gdprId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            // ==========================================
            // 3. CATALOGO MODELLI IA UTILIZZATI
            // ==========================================
            $gpt4oId = DB::table('ai_models')->insertGetId([
                'name' => 'GPT-4o API',
                'provider' => 'OpenAI',
                'hosting_type' => 'SaaS Cloud (US/EU Endpoint)',
                'is_third_party' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $claudeId = DB::table('ai_models')->insertGetId([
                'name' => 'Claude 3.5 Sonnet',
                'provider' => 'Anthropic',
                'hosting_type' => 'AWS Bedrock (EU Region)',
                'is_third_party' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $llamaId = DB::table('ai_models')->insertGetId([
                'name' => 'Llama 3 70B Fine-Tuned',
                'provider' => 'Meta / Internal Development',
                'hosting_type' => 'On-Premise Private Cloud',
                'is_third_party' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $xgboostId = DB::table('ai_models')->insertGetId([
                'name' => 'CreditScore-XGBoost-v2',
                'provider' => 'In-House Data Science Team',
                'hosting_type' => 'Internal Docker Microservice',
                'is_third_party' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ==========================================
            // 4. SISTEMI IA INTEGRATI NEL CRM
            // ==========================================

            // SISTEMA 1: Smart Assistant Email & Note (Rischio Limitato)
            $system1Id = DB::table('ai_systems')->insertGetId([
                'name' => 'CRM AI Smart Assistant (Email & Note)',
                'description' => 'Modulo per la generazione automatica di bozze e-mail commerciali e trascrizione/sintesi delle chiamate clienti.',
                'version' => '2.1.0',
                'owner_id' => $leadDeveloper->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('ai_system_model')->insert([
                ['ai_system_id' => $system1Id, 'ai_model_id' => $gpt4oId],
                ['ai_system_id' => $system1Id, 'ai_model_id' => $claudeId],
            ]);

            // SISTEMA 2: Scoring Creditizio Clienti B2B (Alto Rischio - Allegato III)
            $system2Id = DB::table('ai_systems')->insertGetId([
                'name' => 'CRM Credit Risk & Scoring Engine',
                'description' => 'Modulo per la valutazione automatica della solvibilità dei clienti e la concessione di fidi o dilazioni di pagamento.',
                'version' => '1.0.4',
                'owner_id' => $complianceOfficer->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('ai_system_model')->insert([
                ['ai_system_id' => $system2Id, 'ai_model_id' => $xgboostId],
            ]);

            // SISTEMA 3: Recruitment & HR Screening (Alto Rischio - Allegato III)
            $system3Id = DB::table('ai_systems')->insertGetId([
                'name' => 'CRM Talent Scout & Screening HR',
                'description' => 'Modulo CRM HR per l\'analisi automatica dei CV, scoring dei candidati e ranking delle candidature.',
                'version' => '1.0.0',
                'owner_id' => $leadDeveloper->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('ai_system_model')->insert([
                ['ai_system_id' => $system3Id, 'ai_model_id' => $llamaId],
            ]);

            // SISTEMA 4: Raccomandatore Prodotti (Rischio Minimo)
            $system4Id = DB::table('ai_systems')->insertGetId([
                'name' => 'CRM Cross-Sell Product Recommender',
                'description' => 'Suggeritore di prodotti correlati in fase di creazione preventivo basato sul passato storico degli acquisti.',
                'version' => '3.0.1',
                'owner_id' => $leadDeveloper->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ==========================================
            // 5. CLASSIFICAZIONE DEI RISCHI (RISK ASSESSMENTS)
            // ==========================================
            DB::table('risk_assessments')->insert([
                [
                    'ai_system_id' => $system1Id,
                    'risk_level' => 'limited',
                    'justification' => 'Genera testo (e-mail/sintesi). Si applicano unicamente gli obblighi di trasparenza dell\'Art. 50 (obbligo di notifica contenuto sintetico).',
                    'is_annex_iii' => false,
                    'evaluated_by' => $complianceOfficer->id,
                    'completed_at' => now()->subDays(10),
                    'created_at' => now()->subDays(10),
                    'updated_at' => now()->subDays(10),
                ],
                [
                    'ai_system_id' => $system2Id,
                    'risk_level' => 'high',
                    'justification' => 'Rientra nell\'Allegato III Punto 5 (Valutazione del merito creditizio delle persone fisiche/aziende). Richiede piena conformità.',
                    'is_annex_iii' => true,
                    'evaluated_by' => $complianceOfficer->id,
                    'completed_at' => now()->subDays(5),
                    'created_at' => now()->subDays(5),
                    'updated_at' => now()->subDays(5),
                ],
                [
                    'ai_system_id' => $system3Id,
                    'risk_level' => 'high',
                    'justification' => 'Rientra nell\'Allegato III Punto 4 (Assunzione e selezione del personale). Richiede conformità rigorosa e FRIA.',
                    'is_annex_iii' => true,
                    'evaluated_by' => $complianceOfficer->id,
                    'completed_at' => now()->subDays(2),
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ],
                [
                    'ai_system_id' => $system4Id,
                    'risk_level' => 'minimal',
                    'justification' => 'Semplice sistema di raccomandazione commerciale basato su algoritmi associativi standard. Nessun impatto sui diritti.',
                    'is_annex_iii' => false,
                    'evaluated_by' => $leadDeveloper->id,
                    'completed_at' => now()->subMonth(),
                    'created_at' => now()->subMonth(),
                    'updated_at' => now()->subMonth(),
                ],
            ]);

            // ==========================================
            // 6. SESSIONI DI AUDIT E RISPOSTE AI REQUISITI
            // ==========================================

            // AUDIT 1: Smart Assistant (EU AI Act - Rischio Limitato)
            $audit1Id = DB::table('audits')->insertGetId([
                'ai_system_id' => $system1Id,
                'compliance_framework_id' => $euAiActId,
                'status' => 'compliant',
                'score_percentage' => 100.00,
                'created_at' => now()->subDays(7),
                'updated_at' => now(),
            ]);

            $art4Req = DB::table('framework_requirements')->where('compliance_framework_id', $euAiActId)->where('section_code', 'Art. 4')->first();
            $art50Req = DB::table('framework_requirements')->where('compliance_framework_id', $euAiActId)->where('section_code', 'Art. 50')->first();

            DB::table('audit_answers')->insert([
                [
                    'audit_id' => $audit1Id,
                    'framework_requirement_id' => $art4Req->id,
                    'is_compliant' => true,
                    'notes' => 'Tutto il team commerciale e dev ha completato il corso "AI Safety & Governance 2026". Registri salvati.',
                    'payload' => json_encode(['certified_users_count' => 14, 'course_provider' => 'Internal HR Portal']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'audit_id' => $audit1Id,
                    'framework_requirement_id' => $art50Req->id,
                    'is_compliant' => true,
                    'notes' => 'Inserito nell\'interfaccia un badge permanente "Generato da IA" con disclaimer per l\'operatore prima dell\'invio email.',
                    'payload' => json_encode(['ui_component' => 'AiWatermarkBadge.vue', 'disclaimer_text' => 'Bozza sintetica da verificare']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            // AUDIT 2: Scoring Creditizio (EU AI Act - Alto Rischio - In Review)
            $audit2Id = DB::table('audits')->insertGetId([
                'ai_system_id' => $system2Id,
                'compliance_framework_id' => $euAiActId,
                'status' => 'in_review',
                'score_percentage' => 60.00,
                'created_at' => now()->subDays(3),
                'updated_at' => now(),
            ]);

            $art10Req = DB::table('framework_requirements')->where('compliance_framework_id', $euAiActId)->where('section_code', 'Art. 10')->first();
            $art14Req = DB::table('framework_requirements')->where('compliance_framework_id', $euAiActId)->where('section_code', 'Art. 14')->first();

            DB::table('audit_answers')->insert([
                [
                    'audit_id' => $audit2Id,
                    'framework_requirement_id' => $art10Req->id,
                    'is_compliant' => true,
                    'notes' => 'Dataset di addestramento ripulito da variabili protette (genere, nazionalità). Eseguito test di bias.',
                    'payload' => json_encode(['bias_score' => 0.02, 'dataset_records' => 150000]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'audit_id' => $audit2Id,
                    'framework_requirement_id' => $art14Req->id,
                    'is_compliant' => false,
                    'notes' => 'MANCANZA CRITICA: Manca ancora il pulsante di override manuale per il responsabile crediti in caso di bocciatura automatica.',
                    'payload' => json_encode(['action_required' => 'Aggiungere bottone Override in Filament Dashboard']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            // ==========================================
            // 7. REGISTRO INCIDENTI (POST-MARKET MONITORING)
            // ==========================================
            DB::table('ai_incidents')->insert([
                [
                    'ai_system_id' => $system1Id,
                    'incident_type' => 'Severe Hallucination / Allucinazione',
                    'description' => 'Il sistema di e-mail automatica ha inserito uno sconto del 50% non autorizzato nel testo inviato a un cliente.',
                    'severity' => 'medium',
                    'reported_at' => now()->subDays(12),
                    'resolved_at' => now()->subDays(11),
                    'created_at' => now()->subDays(12),
                    'updated_at' => now()->subDays(11),
                ],
                [
                    'ai_system_id' => $system1Id,
                    'incident_type' => 'Prompt Injection Attempt',
                    'description' => 'Un utente ha provato ad estrarre le istruzioni di sistema (system prompt) inserendo comandi speciali nelle note di chiamata.',
                    'severity' => 'low',
                    'reported_at' => now()->subDays(4),
                    'resolved_at' => now()->subDays(4),
                    'created_at' => now()->subDays(4),
                    'updated_at' => now()->subDays(4),
                ],
                [
                    'ai_system_id' => $system2Id,
                    'incident_type' => 'Data Leak Warning',
                    'description' => 'Invocazione API verso provider con payload contenente un codice fiscale in chiaro non anonimizzato.',
                    'severity' => 'high',
                    'reported_at' => now()->subDays(1),
                    'resolved_at' => null, // Ancora in gestione
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ],
            ]);

        });
    }
}
