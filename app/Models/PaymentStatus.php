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

    // choose hasMany 'cause a status may be links with n payments

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
}
