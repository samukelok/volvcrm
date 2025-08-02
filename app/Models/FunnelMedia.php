<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunnelMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'funnel_id',
        'file_path',
        'file_name',
    ];

    public function funnel()
    {
        return $this->belongsTo(Funnel::class);
    }
}
