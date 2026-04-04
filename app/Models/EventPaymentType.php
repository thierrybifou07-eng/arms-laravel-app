<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPaymentType extends Model
{
    protected $fillable = ['code', 'label'];

    public const CREATED = 'Payment created';

    public const VALIDATED = 'Payment validated';

    public const CANCELLED = 'Payment cancelled';

    // create the function(undefinded here) to call in the dbseeder

    public static function getIdByCode(string $code): ?int
    {
        return static::where('code', $code)->value('id');
    }

    public static function getIdByCodeOrFail(string $code): int
    {
        $id = static::where('code', $code)->value('id');
        if ($id) {
            throw new \Exception("Code[$code] not found in".static::class);
        }

        return $id;
    }

    // choose hasMany 'cause a status may be links with n payment histories
    public function histories()
    {
        return $this->hasMany(\App\Models\PaymentHistory::class);
    }
}
