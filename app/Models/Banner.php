<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'message', 'type', 'is_active', 'show_from', 'show_until', 'priority', 'action_url', 'action_text'];
    protected $casts = ['is_active' => 'boolean', 'show_from' => 'datetime', 'show_until' => 'datetime'];

    public function reads()
    {
        return $this->hasMany(BannerRead::class);
    }
}
