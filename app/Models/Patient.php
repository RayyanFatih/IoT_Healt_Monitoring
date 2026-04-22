<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'patient_id',
        'name',
        'age',
        'institution',
    ];

    public function vitals(): HasMany
    {
        return $this->hasMany(Vital::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
}
