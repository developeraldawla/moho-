<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BannerRead extends Model
{
    protected $fillable = ['banner_id', 'user_id', 'is_dismissed', 'dismissed_at'];
    protected $casts = ['is_dismissed' => 'boolean', 'dismissed_at' => 'datetime'];

    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
