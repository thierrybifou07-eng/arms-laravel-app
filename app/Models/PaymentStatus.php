<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $fillable = ['code', 'label'];

    public const PROCESSING = 'Processing';

    public const PENDING = 'Pending';

    public const PAID = 'Paid';
public const OVERDUE= 'Overdue';

    public const VALIDATED = 'Validated';

    public const CANCELLED = 'Cancelled';

    // create the function(undefinded here) to call in the dbseeder

    public static function getIdByCode(string $code): ?int
    {
        return static::where('code', $code)->value('id');
    }

    public static function getIdByCodeOrFail(string $code): int
    {
        $record = static::where('code', $code)->first();

        if (! $record) {
            throw new \Exception("Code [$code] not found in ".static::class);
        }

        return $record->id;
    }

    // choose hasMany 'cause a status may be links with n payments

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
}
