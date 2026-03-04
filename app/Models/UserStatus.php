<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $fillable = ['code', 'label'];

    public const PENDING = 'pending';

    public const ACTIVE = 'active';

    public const SUSPENDED = 'suspended';

    public const DISABLED = 'disabled';

    //create the function(undefinded here) to call in the dbseeder
    
    public static function getIdByCode(string $code): int
    {
        return static::where('code',$code)->value('id');
    }

    // choose hasMany 'cause a status may be links with n users

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
