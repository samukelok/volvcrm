<?php

namespace App\Jobs;

use App\Models\FunnelStep;
use App\Services\FunnelEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFunnelStepEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $funnelStep;

    public function __construct(FunnelStep $funnelStep)
    {
        $this->funnelStep = $funnelStep;
    }

    public function handle(FunnelEmailService $emailService)
    {
        // Delegates the email sending to the service
        $emailService->sendStepEmails($this->funnelStep);
    }
}
