<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    protected $table = 'monitoring_sessions';

    protected $fillable = [
        'patient_id',
        'name',
        'session_date',
        'session_time',
        'avg_heart_rate',
        'avg_spo2',
        'readings_count',
        'duration',
        'chart_data',
    ];

    protected $casts = [
        'chart_data' => 'array',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
