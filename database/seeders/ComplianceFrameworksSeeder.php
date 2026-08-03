<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplianceFrameworksSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // ==========================================
            // 1. EU AI ACT (Regolamento UE 2024/1689)
            // ==========================================
            $aiActId = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'EU_AI_ACT_2024',
                'title' => 'EU Artificial Intelligence Act (Regolamento UE 2024/1689)',
                'version' => '1.0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $aiActReqs = [
                [
                    'section_code' => 'Art. 4',
                    'title' => 'Alfabetizzazione sull\'IA (AI Literacy)',
                    'description' => 'I fornitori e i distributori adottano misure per garantire che il proprio personale possieda un livello di alfabetizzazione sufficiente sull\'IA.',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high', 'prohibited']),
                ],
                [
                    'section_code' => 'Art. 5',
                    'title' => 'Pratiche di IA Vietate',
                    'description' => 'Verifica dell\'assenza di tecniche subliminali, manipolatorie, di social scoring o di identificazione biometrica remota non autorizzata.',
                    'applicable_risk_levels' => json_encode(['prohibited']),
                ],
                [
                    'section_code' => 'Art. 9',
                    'title' => 'Sistema di Gestione dei Rischi',
                    'description' => 'Istituzione e mantenimento continuo di un sistema continuo di valutazione e mitigazione dei rischi per tutta la durata del ciclo di vita del sistema.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 10',
                    'title' => 'Governance dei Dati e dei Dataset',
                    'description' => 'I dataset di addestramento, convalida e prova devono rispettare criteri di qualità, pertinenza, assenza di bias e corretta rappresentatività.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 11',
                    'title' => 'Documentazione Tecnica',
                    'description' => 'Redazione e aggiornamento della documentazione tecnica prima dell\'immissione sul mercato per dimostrare la conformità (Allegato IV).',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 12',
                    'title' => 'Registrazione degli Eventi (Logging)',
                    'description' => 'Presenza di funzionalità di tracciamento automatico dei log di funzionamento per garantire la tracciabilità e il monitoraggio post-market.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 13',
                    'title' => 'Trasparenza e Istruzioni per i Deployer',
                    'description' => 'Fornitura di istruzioni d\'uso chiare e accessibili che dichiarino capacità, limiti, accuratezza e specifiche tecniche ai clienti.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 14',
                    'title' => 'Sorveglianza Umana (Human Oversight)',
                    'description' => 'Interfacce ed opzioni di override progettate per consentire agli operatori umani di monitorare, prevenire o arrestare l\'output del sistema.',
                    'applicable_risk_levels' => json_encode(['high', 'limited']),
                ],
                [
                    'section_code' => 'Art. 15',
                    'title' => 'Accuratezza, Robustezza e Cybersecurity',
                    'description' => 'Progettazione orientata alla resilienza contro errori, attacchi informatici (es. prompt injection, data poisoning) e fallimenti di sistema.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 27',
                    'title' => 'Valutazione di Impatto sui Diritti Fondamentali (FRIA)',
                    'description' => 'Valutazione dell\'impatto sui diritti fondamentali svolta prima della messa in servizio del sistema di IA ad alto rischio.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 50',
                    'title' => 'Trasparenza per Sistemi di IA Generativa',
                    'description' => 'Obbligo di contrassegnare in modo chiaro e leggibile gli output generati o manipolati da IA (watermarking, badge, disclaimer).',
                    'applicable_risk_levels' => json_encode(['limited', 'high']),
                ],
            ];

            foreach ($aiActReqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, [
                    'compliance_framework_id' => $aiActId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            // ==========================================
            // 2. ISO/IEC 42001:2023 (AIMS Standard)
            // ==========================================
            $iso42001Id = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'ISO_IEC_42001_2023',
                'title' => 'ISO/IEC 42001:2023 - Artificial Intelligence Management System',
                'version' => '2023',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $iso42001Reqs = [
                [
                    'section_code' => 'Control A.5',
                    'title' => 'Valutazione ed Impatto delle Politiche di IA',
                    'description' => 'Definizione di politiche aziendali formali sull\'uso responsabile e accettabile dei sistemi di Intelligenza Artificiale.',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high', 'prohibited']),
                ],
                [
                    'section_code' => 'Control A.6',
                    'title' => 'Gestione dei Dati per Sistemi IA',
                    'description' => 'Tracciabilità della provenienza dei dati, gestione del ciclo di vita dei dataset e tutela della privacy nei flussi di training/RAG.',
                    'applicable_risk_levels' => json_encode(['limited', 'high']),
                ],
                [
                    'section_code' => 'Control A.7',
                    'title' => 'Gestione del Ciclo di Vita del Sistema IA',
                    'description' => 'Definizione dei processi di progettazione, sviluppo, test, deployment e decommissioning dei modelli di IA.',
                    'applicable_risk_levels' => json_encode(['limited', 'high']),
                ],
                [
                    'section_code' => 'Control A.8',
                    'title' => 'Gestione dei Fornitori e Parti Terze (API)',
                    'description' => 'Valutazione della sicurezza, conformità e affidabilità dei fornitori esterni di modelli di IA (es. OpenAI, Anthropic).',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high']),
                ],
            ];

            foreach ($iso42001Reqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, [
                    'compliance_framework_id' => $iso42001Id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            // ==========================================
            // 3. NIST AI Risk Management Framework (NIST AI RMF 1.0)
            // ==========================================
            $nistId = DB::table('compliance_frameworks')->insertGetId([
                'code' => 'NIST_AI_RMF_1.0',
                'title' => 'NIST Artificial Intelligence Risk Management Framework',
                'version' => '1.0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $nistReqs = [
                [
                    'section_code' => 'GOVERN',
                    'title' => 'Cultura e Governance dei Rischi IA',
                    'description' => 'Integrazione dei processi di risk management dell\'IA nelle strutture decisionali ed etiche dell\'organizzazione.',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high']),
                ],
                [
                    'section_code' => 'MAP',
                    'title' => 'Mappatura del Contesto e dei Rischi',
                    'description' => 'Comprensione del contesto applicativo, categorizzazione dei potenziali impatti negativi e dei limiti del sistema.',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high']),
                ],
                [
                    'section_code' => 'MEASURE',
                    'title' => 'Misurazione e Valutazione delle Performance',
                    'description' => 'Analisi quantitativa e qualitativa di accuratezza, bias, allucinazioni, sicurezza e affidabilità dell\'algoritmo.',
                    'applicable_risk_levels' => json_encode(['limited', 'high']),
                ],
                [
                    'section_code' => 'MANAGE',
                    'title' => 'Gestione e Mitigazione dei Rischi',
                    'description' => 'Allocazione delle risorse per la risposta e prioritizzazione dei rischi identificati nelle fasi precedenti.',
                    'applicable_risk_levels' => json_encode(['limited', 'high']),
                ],
            ];

            foreach ($nistReqs as $req) {
                DB::table('framework_requirements')->insert(array_merge($req, [
                    'compliance_framework_id' => $nistId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }

            // ==========================================
            // 4. GDPR (Focus Dati Personali e IA)
            // ==========================================
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
                    'title' => 'Basi Giuridiche e Dati Particolari',
                    'description' => 'Verifica della base giuridica appropriata per l\'uso dei dati dei clienti nelle invocazioni e nei prompt dell\'IA.',
                    'applicable_risk_levels' => json_encode(['minimal', 'limited', 'high']),
                ],
                [
                    'section_code' => 'Art. 22',
                    'title' => 'Processo Decisionale Automatizzato e Profilazione',
                    'description' => 'Garantire il diritto dell\'interessato a non essere sottoposto ad una decisione basata unicamente sul trattamento automatizzato.',
                    'applicable_risk_levels' => json_encode(['high']),
                ],
                [
                    'section_code' => 'Art. 35',
                    'title' => 'Valutazione di Impatto sulla Protezione dei Dati (DPIA)',
                    'description' => 'Svolgimento obbligatorio della DPIA quando il trattamento con l\'IA prevede l\'uso sistematico di dati su larga scala.',
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

        });
    }
}
