<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficerLoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'officer_id',
        'time_in',
        'time_out',
        'latitude',
        'longitude',
    ];

    // Relation to officer
    public function officer()
    {
        return $this->belongsTo(OfficerUser::class, 'officer_id');
    }
}
