<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'surname',
        'given_name',
        'middlename',
        'identification_number',
        'phone',
        'email',
    ];

    // relationship with contracts
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
