<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingPeriod extends Model
{
    protected $fillable = ['code', 'label'];
    public const monthly = 'Monthly';
    public const quaterly = 'Quarterly';
    public const half_yearly = 'Half-Yearly';
    public const yearly = 'Yearly';

    //create the function(undefinded here) to call in the dbseeder
    
    public static function getIdByCode(string $code): int
    {
        return self::where('code',$code)->value('id');
    }

    // choose hasMany 'cause a status may be links with n users

    public function contracts()
    {
        return $this->hasMany(\App\Models\Contract::class);
    }
}
