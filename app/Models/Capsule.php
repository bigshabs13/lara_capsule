<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'message', 'gps_latitude', 'gps_longitude', 'ip_address',
        'mood_id', 'is_public', 'reveal_at', 'revealed_at', 'country'
    ];

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }
}
