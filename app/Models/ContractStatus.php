<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractStatus extends Model
{
    protected $fillable = ['code', 'label'];
    public const pending = 'Pending';
    public const active = 'Active';
    public const terminated = 'Terminated';
    public const cancelled = 'Cancelled';

    //create the function(undefinded here) to call in the dbseeder
    
    public static function getIdByCode(string $code): int
    {
        return static::where('code',$code)->value('id');
    }

    // choose hasMany 'cause a status may be links with n users

    public function contracts()
    {
        return $this->hasMany(\App\Models\Contract::class);
    }
}
