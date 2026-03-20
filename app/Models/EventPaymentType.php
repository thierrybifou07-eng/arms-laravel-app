<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPaymentType extends Model
{
    protected $fillable = ['code', 'label'];
    public const created = 'Payment created';
    public const validated = 'Payment validated';
    public const cancelled = 'Payment cancelled';

    //create the function(undefinded here) to call in the dbseeder
    
    public static function getIdByCode(string $code): int
    {
        return self::where('code',$code)->value('id');
    }

    // choose hasMany 'cause a status may be links with n users
}
