<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use Auditable;

    protected $fillable = ['code', 'label'];

    public const CASH = 'cash';

    public const MTN_MONEY = 'MTN Mobile Money';

    public const ORANGE_MONEY = 'Orange Money';

    public const CRYPTOS = 'Cryptocurrencies';

    public const BANK_TRANSFERT = 'Bank Transfer';

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
