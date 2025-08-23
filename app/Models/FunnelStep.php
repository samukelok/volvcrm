<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FunnelStep extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'funnel_id',
        'name',
        'step_order',
        'delay_hours',
        'condition',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function funnel()
    {
        return $this->belongsTo(Funnel::class);
    }

    public function emailTemplates()
    {
        return $this->belongsToMany(EmailTemplate::class, 'funnel_step_email_template')
                    ->withPivot('order_in_step')
                    ->withTimestamps()
                    ->orderBy('pivot_order_in_step');
    }
}
