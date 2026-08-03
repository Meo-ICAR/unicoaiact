<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class FriaAssessment extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function aiSystem(): BelongsTo
    {
        return $this->belongsTo(AiSystem::class);
    }

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assessed_by');
    }
}
