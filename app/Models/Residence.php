<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    //
    protected $fillable = [
        'residence_status_id',
        'name',
        'address',
        'capacity',
    ];

    // relationship with the manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Assign a status

    public function status()
    {
        return $this->belongsTo(ResidenceStatus::class, 'residence_status_id');
    }
    // relationship with buildings

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
