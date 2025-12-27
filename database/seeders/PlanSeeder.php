<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name_en' => 'Pro Plan',
            'name_tr' => 'Pro Plan',
            'description' => 'All access to premium AI tools.',
            'price' => 29.00,
            'currency' => 'USD',
            'interval' => 'month',
            'has_trial' => true,
            'trial_days' => 3,
            'is_active' => true,
            'features' => json_encode(['All Tools', 'Priority Support', 'High Limits']),
        ]);

        Plan::create([
            'name_en' => 'Annual Pro Plan',
            'name_tr' => 'Yıllık Pro Plan',
            'description' => 'Save 20% with annual billing.',
            'price' => 290.00,
            'currency' => 'USD',
            'interval' => 'year',
            'has_trial' => true,
            'trial_days' => 3,
            'is_active' => true,
            'features' => json_encode(['All Tools', 'Priority Support', 'High Limits', '2 Months Free']),
        ]);
    }
}
