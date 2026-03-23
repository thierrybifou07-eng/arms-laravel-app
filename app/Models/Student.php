<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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
        protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // relationship with contracts
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
