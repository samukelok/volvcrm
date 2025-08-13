<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'niche_category',
        'email',
        'phone',
        'funnel_id',
        'source',
        'source_type',
        'status',
        'pays',
        'client_id',
        'notes',
        'lead_belongs_to',
        'metadata',
        'contacted_at',
        'converted_at',
        'deleted_reason',
        'is_test',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
        'converted_at' => 'datetime',
        'metadata' => 'json',
        'lead_belongs_to' => 'json',
        'is_test' => 'boolean',
    ];

    public function funnel()
    {
        return $this->belongsTo(Funnel::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    // Status Change History
    public function statusChanges()
    {
        return $this->hasMany(LeadStatusChange::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'converted');
    }

    public function scopeTest($query)
    {
        return $query->where('is_test', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
