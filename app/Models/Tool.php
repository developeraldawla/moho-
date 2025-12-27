<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_tr',
        'description_en',
        'description_tr',
        'icon',
        'category',
        'n8n_webhook_url',
        'input_fields',
        'output_type',
        'is_active',
        'is_premium',
        'daily_limit_default'
    ];

    protected $casts = [
        'input_fields' => 'array',
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
    ];

    public function usageLogs()
    {
        return $this->hasMany(UsageLog::class);
    }
}
