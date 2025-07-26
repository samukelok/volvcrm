<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'goal',
        'target_audience',
        'cta',
        'notes',
        'deadline',
        'user_id',
        'client_id',
        'is_active',
        'priority',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Scope: only active funnels
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
