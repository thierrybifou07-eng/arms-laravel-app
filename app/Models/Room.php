<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

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
    // relationship with contracts

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    // Assign a status

    public function status()
    {
        return $this->belongsTo(RoomStatus::class, 'room_status_id');
    }
}
