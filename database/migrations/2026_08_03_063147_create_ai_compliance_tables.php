<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Organizzazioni (Multi-Tenancy / UnicoConsultant)
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('vat_number')->nullable();
            $table->enum('type', ['company', 'public_sector', 'consultant_agency'])->default('company');
            $table->timestamps();
        });

        // 2. Sistemi IA (Core Inventory + Shadow AI + Human Oversight + EU DB)
        Schema::create('ai_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('version')->default('1.0.0');
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();

            // Shadow AI & Workflow Approvazione (UnicoBPM)
            $table->boolean('is_shadow_ai')->default(false);
            $table->string('discovery_method')->nullable(); // es. Scanner di Rete, Manuale
            $table->enum('approval_status', ['draft', 'pending_approval', 'approved', 'rejected'])->default('draft');

            // Human Oversight & Kill Switch (Pilastro 3)
            $table->enum('human_oversight_type', ['human_in_the_loop', 'human_on_the_loop', 'human_in_command'])->nullable();
            $table->boolean('has_kill_switch')->default(false);
            $table->text('kill_switch_procedure')->nullable();

            // Registrazione Banca Dati UE (Pilastro 4)
            $table->string('eu_db_registration_id')->nullable();
            $table->enum('eu_registration_status', ['not_required', 'pending', 'registered'])->default('not_required');

            $table->timestamps();
        });

        // 3. Modelli IA Utilizzati
        Schema::create('ai_models', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // es. GPT-4o, Claude 3.5 Sonnet, Custom Scikit
            $table->string('provider'); // es. OpenAI, Anthropic, Internal
            $table->string('hosting_type'); // SaaS, Private Cloud, On-Premise
            $table->boolean('is_third_party')->default(true);
            $table->timestamps();
        });

        // Pivot Sistemi <-> Modelli
        Schema::create('ai_system_model', function (Blueprint $table) {
            $table->foreignId('ai_system_id')->constrained('ai_systems')->cascadeOnDelete();
            $table->foreignId('ai_model_id')->constrained('ai_models')->cascadeOnDelete();
            $table->primary(['ai_system_id', 'ai_model_id']);
        });

        // 4. Classificazione Rischio EU AI Act
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_system_id')->constrained('ai_systems')->cascadeOnDelete();
            $table->enum('risk_level', ['prohibited', 'high', 'limited', 'minimal']);
            $table->text('justification');
            $table->boolean('is_annex_iii')->default(false);
            $table->foreignId('evaluated_by')->constrained('users');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 5. Framework Normativi (EU AI Act, ISO 42001, NIST, GDPR)
        Schema::create('compliance_frameworks', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // es. EU_AI_ACT_2024
            $table->string('title');
            $table->string('version');
            $table->timestamps();
        });

        // Requisiti di legge dei Framework
        Schema::create('framework_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compliance_framework_id')->constrained('compliance_frameworks')->cascadeOnDelete();
            $table->string('section_code'); // es. Art. 4, Art. 50
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('applicable_risk_levels'); // ["high", "limited"]
            $table->timestamps();
        });

        // 6. Sessioni di Audit / Conformità
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_system_id')->constrained('ai_systems')->cascadeOnDelete();
            $table->foreignId('compliance_framework_id')->constrained('compliance_frameworks')->cascadeOnDelete();
            $table->enum('status', ['draft', 'in_review', 'compliant', 'non_compliant'])->default('draft');
            $table->decimal('score_percentage', 5, 2)->nullable();
            $table->timestamps();
        });

        // Risposte agli articoli dell'audit
        Schema::create('audit_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_id')->constrained('audits')->cascadeOnDelete();
            $table->foreignId('framework_requirement_id')->constrained('framework_requirements')->cascadeOnDelete();
            $table->boolean('is_compliant')->nullable();
            $table->text('notes')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });

        // 7. Valutazione d'Impatto sui Diritti Fondamentali (FRIA - Pilastro 2)
        Schema::create('fria_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_system_id')->constrained('ai_systems')->cascadeOnDelete();
            $table->foreignId('gdpr_dpia_id')->nullable(); // Integrazione UnicoGDPR
            $table->text('affected_categories');
            $table->text('fundamental_rights_impact');
            $table->text('mitigation_measures');
            $table->foreignId('assessed_by')->constrained('users');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 8. Bias Testing e Performance Drift (Pilastro 4)
        Schema::create('bias_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_system_id')->constrained('ai_systems')->cascadeOnDelete();
            $table->string('test_name');
            $table->decimal('fairness_score', 5, 2)->nullable();
            $table->decimal('drift_score', 5, 2)->nullable();
            $table->boolean('passed')->default(true);
            $table->json('metrics_payload')->nullable();
            $table->timestamp('tested_at');
            $table->timestamps();
        });

        // 9. Inviolabilità Crittografica Post-Quantistica WORM (UnicoPQC)
        Schema::create('pqc_signatures', function (Blueprint $table) {
            $table->id();
            $table->morphs('signable'); // Riferimento polimorfico a Audit, Logs, RiskAssessments
            $table->string('hash_algorithm')->default('SHA3-512');
            $table->text('data_hash');
            $table->text('pqc_signature'); // Firma Crittografica Post-Quantistica
            $table->timestamp('sealed_at');
            $table->timestamps();
        });

        // 10. Metriche ESG (UnicoESG Integration - E & G Score)
        Schema::create('esg_ai_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_system_id')->constrained('ai_systems')->cascadeOnDelete();
            $table->decimal('estimated_kwh_consumption', 10, 2)->nullable();
            $table->decimal('carbon_footprint_kg', 10, 2)->nullable();
            $table->decimal('ethical_governance_score', 5, 2)->nullable();
            $table->timestamps();
        });

        // 11. Registro Incidenti e Notifica Autorità
        Schema::create('ai_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_system_id')->constrained('ai_systems')->cascadeOnDelete();
            $table->string('incident_type');
            $table->text('description');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('low');

            // Notifica ad Autorità Nazionale
            $table->boolean('reported_to_authority')->default(false);
            $table->timestamp('authority_notified_at')->nullable();
            $table->string('authority_reference_code')->nullable();

            $table->timestamp('reported_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_incidents');
        Schema::dropIfExists('esg_ai_metrics');
        Schema::dropIfExists('pqc_signatures');
        Schema::dropIfExists('bias_tests');
        Schema::dropIfExists('fria_assessments');
        Schema::dropIfExists('audit_answers');
        Schema::dropIfExists('audits');
        Schema::dropIfExists('framework_requirements');
        Schema::dropIfExists('compliance_frameworks');
        Schema::dropIfExists('risk_assessments');
        Schema::dropIfExists('ai_system_model');
        Schema::dropIfExists('ai_models');
        Schema::dropIfExists('ai_systems');
        Schema::dropIfExists('organizations');
    }
};
