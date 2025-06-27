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
        'brand_name',
        'website',
        'subdomain',
        'status',
        'onboarded_at',
        'branding',
    ];

    protected $casts = [
        'onboarded_at' => 'datetime',
        'branding' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
