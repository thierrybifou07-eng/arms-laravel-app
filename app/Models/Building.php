<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Building extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'residence_id',
        'building_status_id',
        'name',
        'address',
        'capacity',
    ];

    // relationship with residence

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    // Assign a status

    public function status()
    {
        return $this->belongsTo(BuildingStatus::class, 'building_status_id');
    }
    // relationship with floors

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }
}
