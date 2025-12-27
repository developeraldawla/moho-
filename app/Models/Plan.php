<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name_en', 'name_tr', 'price', 'currency', 'interval', 'stripe_product_id', 'stripe_price_id', 'features', 'has_trial', 'trial_days', 'trial_price', 'is_active', 'sort_order'];
    protected $casts = ['features' => 'array', 'price' => 'decimal:2', 'has_trial' => 'boolean'];

    public function toolLimits()
    {
        return $this->hasMany(ToolPlanLimit::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}
