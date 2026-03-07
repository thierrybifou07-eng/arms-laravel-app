<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
     protected $fillable = [
        'floor_id',
        'room_status_id',
        'number',
        'rent',
        'capacity',
    ];

        // relationship with floor

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

        // Assign a status

    public function status()
    {
        return $this->belongsTo(RoomStatus::class, 'room_status_id');
    }
}
