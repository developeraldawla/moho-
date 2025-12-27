<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'stripe_customer_id', 'stripe_subscription_id', 'status', 'trial_ends_at', 'starts_at', 'ends_at', 'cancelled_at'];
    protected $casts = ['trial_ends_at' => 'datetime', 'starts_at' => 'datetime', 'ends_at' => 'datetime', 'cancelled_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
