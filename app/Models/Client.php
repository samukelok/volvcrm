<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'subdomain',
        'database_name',
        'status',
        'onboarded_at',
        'branding',
    ];

    protected $casts = [
        'onboarded_at' => 'datetime',
        'branding' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('permissions');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}