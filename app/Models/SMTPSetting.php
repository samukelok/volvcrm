<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMTPSetting extends Model
{

    protected $table = "smtp_settings";
    protected $fillable = [
        'name',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'client_id',
        'fallback',
    ];

    protected $casts = [
        'fallback' => 'boolean',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
}
