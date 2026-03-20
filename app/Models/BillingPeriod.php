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
