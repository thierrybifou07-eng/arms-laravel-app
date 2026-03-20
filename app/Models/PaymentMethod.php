<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['code', 'label'];

    public const cash = 'cash';

    public const mtn_money = 'MTN Mobile Money';

    public const orange_money = 'Orange Money';

    public const cryptos = 'Cryptocurrencies';

    public const bank_transfer = 'Bank Transfer';

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
