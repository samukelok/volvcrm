<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id', 
        'email_template_id', 
        'funnel_step_id', 
        'sent_at', 
        'opened_at', 
        'clicked_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }

    public function step()
    {
        return $this->belongsTo(FunnelStep::class, 'funnel_step_id');
    }
}
