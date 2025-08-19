<?php

namespace App\Mail;

use App\Models\Funnel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdatedFunnelNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $funnel;

    public function __construct(Funnel $funnel)
    {
        $this->funnel = $funnel;
    }

    public function build()
    {
        return $this->subject('Funnel Updated: ' . $this->funnel->title)
                    ->view('emails.updated_funnel');
    }
}
