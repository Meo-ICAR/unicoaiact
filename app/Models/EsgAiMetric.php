<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class EsgAiMetric extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'esg_ai_metrics';

    protected $guarded = [];

    protected $casts = [
        'estimated_kwh_consumption' => 'decimal:2',
        'carbon_footprint_kg' => 'decimal:2',
        'ethical_governance_score' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function aiSystem(): BelongsTo
    {
        return $this->belongsTo(AiSystem::class);
    }
}
