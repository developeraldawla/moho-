<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ToolPlanLimit extends Model
{
    protected $fillable = ['plan_id', 'tool_id', 'daily_limit', 'monthly_limit', 'is_unlimited'];
    protected $casts = ['daily_limit' => 'integer', 'monthly_limit' => 'integer', 'is_unlimited' => 'boolean'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
