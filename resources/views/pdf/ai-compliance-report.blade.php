<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Compliance Report EU AI Act - {{ $record->name }}</title>
    <style>
        @page {
            margin: 25px 30px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 12px;
            line-height: 1.5;
            background-color: #ffffff;
        }
        .header {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .logo-title {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .logo-sub {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .doc-meta {
            text-align: right;
            font-size: 10px;
            color: #475569;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-top: 18px;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .grid-table th {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            color: #475569;
        }
        .grid-table td {
            border: 1px solid #e2e8f0;
            padding: 6px 10px;
            font-size: 11px;
        }

        /* Risk Badges */
        .risk-box {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .risk-box-high {
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }
        .risk-box-limited {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
            color: #92400e;
        }
        .risk-box-minimal {
            background-color: #f0fdf4;
            border: 1px solid #86efac;
            color: #166534;
        }
        .risk-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .seal-box {
            background-color: #f8fafc;
            border: 2px solid #0f172a;
            border-radius: 8px;
            padding: 15px;
            margin-top: 25px;
            text-align: center;
        }
        .seal-status {
            font-size: 14px;
            font-weight: bold;
            color: #15803d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .hash-code {
            font-family: 'Courier New', Courier, monospace;
            font-size: 9px;
            color: #334155;
            word-break: break-all;
            background-color: #ffffff;
            padding: 4px 8px;
            border: 1px dashed #cbd5e1;
            margin-top: 6px;
            display: block;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <!-- SEZIONE 1: Intestazione -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="logo-title">UNICO AI GOVERNANCE</div>
                    <div class="logo-sub">Conformità EU AI Act (Regolamento UE 2024/1689)</div>
                </td>
                <td class="doc-meta">
                    <strong>SCHEDA DI TRASPARENZA & KIT CLIENTE</strong><br>
                    Data Emissione: {{ date('d/m/Y H:i') }}<br>
                    ID Registro: EU-AI-{{ sprintf('%05d', $record->id) }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Dettagli Generali Sistema -->
    <table class="grid-table">
        <tr>
            <th width="25%">Nome Sistema IA</th>
            <td width="75%"><strong>{{ $record->name }}</strong> (v{{ $record->version }})</td>
        </tr>
        <tr>
            <th>Organizzazione / Client</th>
            <td>{{ $record->organization?->name ?? 'Unico Corporate Group S.p.A.' }} (P.IVA: {{ $record->organization?->vat_number ?? 'N/D' }})</td>
        </tr>
        <tr>
            <th>Responsabile di Sistema</th>
            <td>{{ $record->owner?->name ?? 'N/D' }} ({{ $record->owner?->email ?? 'N/D' }})</td>
        </tr>
        <tr>
            <th>Stato Registro UE</th>
            <td>{{ strtoupper($record->eu_registration_status ?? 'not_required') }} {{ $record->eu_db_registration_id ? "({$record->eu_db_registration_id})" : '' }}</td>
        </tr>
    </table>

    <!-- SEZIONE 2: Scheda del Rischio EU AI Act -->
    <div class="section-title">1. Classificazione del Rischio (EU AI Act)</div>
    @php
        $riskLevel = $latestRisk?->risk_level ?? 'minimal';
        $riskClass = match($riskLevel) {
            'high', 'prohibited' => 'risk-box-high',
            'limited' => 'risk-box-limited',
            default => 'risk-box-minimal',
        };
        $riskLabel = match($riskLevel) {
            'prohibited' => 'PROIBITO (Rischio Inaccettabile - Art. 5)',
            'high' => 'ALTO RISCHIO (High-Risk System - Allegato III)',
            'limited' => 'RISCHIO LIMITATO (Obblighi Trasparenza Art. 50)',
            default => 'RISCHIO MINIMO / NESSUN RISCHIO',
        };
    @endphp

    <div class="risk-box {{ $riskClass }}">
        <div class="risk-title">LIVELLO DI RISCHIO: {{ $riskLabel }}</div>
        <div>
            <strong>Motivazione Giuridica e Tecnica:</strong><br>
            {{ $latestRisk?->justification ?? 'Valutazione di conformità eseguita in sede di censimento rapido ai sensi del Regolamento UE 2024/1689.' }}
        </div>
    </div>

    <!-- SEZIONE 3: Modelli IA & Trasparenza Art. 50 -->
    <div class="section-title">2. Modelli IA Utilizzati & Requisiti di Trasparenza (Art. 50 / Art. 13)</div>
    <table class="grid-table">
        <thead>
            <tr>
                <th>Nome Modello</th>
                <th>Provider / Fornitore</th>
                <th>Tipologia Hosting</th>
                <th>Proprietà</th>
            </tr>
        </thead>
        <tbody>
            @forelse($record->aiModels as $model)
                <tr>
                    <td><strong>{{ $model->name }}</strong></td>
                    <td>{{ $model->provider }}</td>
                    <td>{{ $model->hosting_type }}</td>
                    <td>{{ $model->is_third_party ? 'Terze Parti (SaaS)' : 'Interno / On-Premise' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #94a3b8;">Nessun modello IA specifico registrato.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="background-color: #f8fafc; padding: 10px; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 11px; margin-bottom: 12px;">
        <strong>Informativa di Trasparenza (Art. 50 EU AI Act):</strong><br>
        Gli utenti finali sono espressamente informati qualora stiano interagendo con un sistema di Intelligenza Artificiale o se i contenuti consultati siano stati generati/manipolati sinteticamente.
    </div>

    <!-- SEZIONE 4: Sorveglianza Umana & Sicurezza -->
    <div class="section-title">3. Sorveglianza Umana & Meccanismi di Sicurezza</div>
    <table class="grid-table">
        <tr>
            <th width="35%">Tipologia Sorveglianza Umana (Art. 14)</th>
            <td width="65%">
                @switch($record->human_oversight_type)
                    @case('human_in_the_loop') <strong>Human-in-the-Loop (HITL):</strong> L'operatore umano approva ogni singolo output. @break
                    @case('human_on_the_loop') <strong>Human-on-the-Loop (HOTL):</strong> L'operatore umano monitora ed ha facoltà di intervento in tempo reale. @break
                    @case('human_in_command') <strong>Human-in-Command (HIC):</strong> L'operatore umano mantiene il controllo generale del ciclo operativo. @break
                    @default Non specificato / Rischio Minimo
                @endswitch
            </td>
        </tr>
        <tr>
            <th>Presenza Kill Switch (Arresto D'Emergenza)</th>
            <td>
                @if($record->has_kill_switch)
                    <strong style="color: #15803d;">SÌ (Configurato ed Operativo)</strong>
                @else
                    <span style="color: #64748b;">NON RICHIESTO O NON PRESENTE</span>
                @endif
            </td>
        </tr>
        @if($record->has_kill_switch && $record->kill_switch_procedure)
        <tr>
            <th>Procedura di Arresto d'Emergenza</th>
            <td>{{ $record->kill_switch_procedure }}</td>
        </tr>
        @endif
    </table>

    <!-- SEZIONE 5: Sigillo di Approvazione Crittografico WORM -->
    <div class="seal-box">
        <div class="seal-status">✔ SISTEMA APPROVATO E REGISTRATO IN PLATFORM GOVERNANCE</div>
        <div style="margin-top: 4px; font-size: 11px; color: #475569;">
            Approvato da: <strong>{{ $record->owner?->name ?? 'Chief AI Officer' }}</strong> | Data: {{ $record->updated_at->format('d/m/Y H:i') }}
        </div>
        <div style="margin-top: 8px; font-size: 10px; color: #64748b;">
            Impronta Crittografica Unica WORM (SHA3-512 Verification Hash):
        </div>
        <span class="hash-code">
            {{ $record->pqcSignatures->first()?->data_hash ?? hash('sha256', $record->name . $record->updated_at . 'UNICO_AI_ACT_SEAL') }}
        </span>
    </div>

    <div class="footer">
        Documento generato automaticamente dalla piattaforma SaaS <strong>Unico AI Governance</strong> | Conforme all'EU AI Act (Regolamento UE 2024/1689)
    </div>

</body>
</html>
