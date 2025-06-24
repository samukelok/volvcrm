<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $inviter;
    public $client;
    public $token;
    public $role;

    public function __construct($inviter, $client, $token, $role)
    {
        $this->inviter = $inviter;
        $this->client = $client;
        $this->token = $token;
        $this->role = $role;
    }

    public function build()
    {
        return $this->subject('Invitation to join ' . $this->client->name)
                    ->markdown('emails.team-invitation');
    }
}