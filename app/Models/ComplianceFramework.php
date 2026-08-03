<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComplianceFramework extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requirements(): HasMany
    {
        return $this->hasMany(FrameworkRequirement::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(Audit::class);
    }
}
