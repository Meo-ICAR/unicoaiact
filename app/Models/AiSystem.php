<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class AiSystem extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'is_shadow_ai' => 'boolean',
        'has_kill_switch' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function aiModels(): BelongsToMany
    {
        return $this->belongsToMany(AiModel::class, 'ai_system_model');
    }

    public function riskAssessments(): HasMany
    {
        return $this->hasMany(RiskAssessment::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(Audit::class);
    }

    public function friaAssessments(): HasMany
    {
        return $this->hasMany(FriaAssessment::class);
    }

    public function biasTests(): HasMany
    {
        return $this->hasMany(BiasTest::class);
    }

    public function esgMetrics(): HasMany
    {
        return $this->hasMany(EsgAiMetric::class);
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(AiIncident::class);
    }
}
