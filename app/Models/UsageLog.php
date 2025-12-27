<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tool_id',
        'input_data',
        'output_data',
        'status',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'input_data' => 'array',
        'output_data' => 'array',
    ];
}
