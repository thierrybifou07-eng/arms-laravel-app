<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class BillingPeriod extends Model
{
    use Auditable;

    protected $fillable = ['code', 'label'];

    public const ONCE = 'One-time';

    public const MONTHLY = 'Monthly';

    public const QUARTERLY = 'Quarterly';

    public const HALF_YEARLY = 'Half-Yearly';

    public const YEARLY = 'Yearly';

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

    // choose hasMany 'cause a status may be links with n contracts

    public function contracts()
    {
        return $this->hasMany(\App\Models\Contract::class);
    }
}
