<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SavedWork extends Model
{
    protected $fillable = ['user_id', 'tool_id', 'title', 'input_data', 'output_data', 'is_favorite'];
    protected $casts = ['input_data' => 'array', 'output_data' => 'array', 'is_favorite' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
