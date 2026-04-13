<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Floor extends Model implements AuditableContract
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'building_id',
        'floor_status_id',
        'number',
        'capacity',
    ];

    // relationship with building

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // Assign a status

    public function status()
    {
        return $this->belongsTo(FloorStatus::class, 'floor_status_id');
    }
    // relationship with rooms

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
