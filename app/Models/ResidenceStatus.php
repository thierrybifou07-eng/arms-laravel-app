<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidenceStatus extends Model
{
    protected $fillable = ['code', 'label'];

    public const PENDING = 'pending';

    public const ACTIVE = 'active';

    public const CLOSED = 'closed';

    public const RENEW = 'renew';

    //create the function(undefinded here) to call in the dbseeder
    
    public static function getIdByCode(string $code): int
    {
        return static::where('code',$code)->value('id');
    }

    // choose hasMany 'cause a status may be links with n users

    public function residences()
    {
        return $this->hasMany(\App\Models\Residence::class);
    }
}
