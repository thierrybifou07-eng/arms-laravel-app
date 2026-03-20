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

    //create the function(undefinded here) to call in the dbseeder
    
    public static function getIdByCode(string $code): int
    {
        return self::where('code',$code)->value('id');
    }

    // choose hasMany 'cause a status may be links with n users

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }
}