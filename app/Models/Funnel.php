<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funnel extends Model
{
    use HasFactory, SoftDeletes;

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
        'preview_link',
        'deleted_reason',
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

    public function media()
    {
        return $this->hasMany(FunnelMedia::class);
    }

     public function leads()
    {
        return $this->hasMany(Lead::class, 'funnel_id');
    }

    // Scope: only active funnels
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
