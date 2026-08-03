<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AiModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_third_party' => 'boolean',
        ];
    }

    public function systems(): BelongsToMany
    {
        return $this->belongsToMany(AiSystem::class, 'ai_system_model');
    }
}
