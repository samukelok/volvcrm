<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'body_html',
        'body_text',
        'category',
        'is_default',
        'client_id',
        'user_id',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'category' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
