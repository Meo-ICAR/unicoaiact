<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Sistemi IA
        Schema::create('ai_systems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('version')->default('1.0.0');
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // 2. Modelli IA Utilizzati
        Schema::create('ai_models', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // es. GPT-4o, Claude 3.5 Sonnet
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

        // 3. Classificazione Rischio AI Act
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

        // 4. Framework Normativi (es. EU AI Act 2024)
        Schema::create('compliance_frameworks', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // es. EU_AI_ACT
            $table->string('title');
            $table->string('version');
            $table->timestamps();
        });

        // Requisiti di legge del Framework
        Schema::create('framework_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compliance_framework_id')->constrained('compliance_frameworks')->cascadeOnDelete();
            $table->string('section_code'); // es. Art. 4, Art. 50
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('applicable_risk_levels'); // ["high", "limited"]
            $table->timestamps();
        });

        // 5. Sessioni di Audit / Conformità
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

        // 6. Registro Incidenti (Post-market Monitoring)
        Schema::create('ai_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_system_id')->constrained('ai_systems')->cascadeOnDelete();
            $table->string('incident_type');
            $table->text('description');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->timestamp('reported_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_incidents');
        Schema::dropIfExists('audit_answers');
        Schema::dropIfExists('audits');
        Schema::dropIfExists('framework_requirements');
        Schema::dropIfExists('compliance_frameworks');
        Schema::dropIfExists('risk_assessments');
        Schema::dropIfExists('ai_system_model');
        Schema::dropIfExists('ai_models');
        Schema::dropIfExists('ai_systems');
    }
};
