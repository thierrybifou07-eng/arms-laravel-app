<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $fillable = ['code', 'label'];

    public const pending = 'Pending';

    public const paid = 'Paid';

    public const validated = 'Validated';

    public const cancelled = 'Cancelled';

    // create the function(undefinded here) to call in the dbseeder

    public static function getIdByCode(string $code): int
    {
        return self::where('code', $code)->value('id');
    }

    // choose hasMany 'cause a status may be links with n users

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
}