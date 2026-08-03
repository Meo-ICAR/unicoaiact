<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AiIncident extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'reported_to_authority' => 'boolean',
        'authority_notified_at' => 'datetime',
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('incident_logs');
    }

    public function aiSystem(): BelongsTo
    {
        return $this->belongsTo(AiSystem::class);
    }
}
