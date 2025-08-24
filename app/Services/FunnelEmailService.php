<?php

namespace App\Services;

use App\Models\FunnelStep;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;

class FunnelEmailService
{
    public function sendStepEmails(FunnelStep $step)
    {
        $leads = $step->funnel->leads;
        $templates = $step->emailTemplates()->orderBy('pivot_order_in_step')->get();

        foreach ($leads as $lead) {
            foreach ($templates as $template) {
                // Create EmailLog
                $emailLog = EmailLog::create([
                    'lead_id' => $lead->id,
                    'email_template_id' => $template->id,
                    'funnel_step_id' => $step->id,
                    'sent_at' => now(),
                ]);

                // HTML content with tracking pixel
                $htmlContent = $template->body_html .
                    '<img src="' . url("/track/open/{$lead->id}/{$emailLog->id}") . '" width="1" height="1"/>';

                // Plain text fallback (optional)
                $textContent = $template->body_text ?? strip_tags($template->body_html);

                // Send email
                Mail::send([], [], function ($message) use ($lead, $template, $htmlContent, $textContent) {
                    $message->to($lead->email)
                        ->subject($template->subject)
                        ->html($htmlContent) 
                        ->text($textContent); 
                });
            }
        }
    }
}
