<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funnel;
use App\Models\FunnelStep;
use App\Models\EmailTemplate;

class FunnelSeeder extends Seeder
{
    public function run()
    {
        $funnel = Funnel::factory()->create([
            'title' => 'Demo Drip Funnel',
            'goal' => 'Convert trial users to paid',
        ]);

        $templates = EmailTemplate::factory(3)->create();

        $step1 = FunnelStep::factory()->create([
            'funnel_id' => $funnel->id,
            'step_order' => 1,
            'delay_hours' => 0,
            'name' => 'Welcome Email',
        ]);

        $step2 = FunnelStep::factory()->create([
            'funnel_id' => $funnel->id,
            'step_order' => 2,
            'delay_hours' => 24,
            'name' => 'Follow-up Email',
        ]);

        // Attach templates to steps
        $step1->emailTemplates()->attach($templates[0]->id, ['order_in_step' => 1]);
        $step2->emailTemplates()->attach($templates[1]->id, ['order_in_step' => 1]);
        $step2->emailTemplates()->attach($templates[2]->id, ['order_in_step' => 2]);
    }
}
