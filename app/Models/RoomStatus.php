<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    protected $fillable = ['code', 'label'];

    public const AVALAIBLE = 'avalaible';

    public const BUSY = 'busy';

    public const RENEW = 'renew';

    public const CLOSED = 'closed';

    //create the function(undefinded here) to call in the dbseeder
    
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

    // choose hasMany 'cause a status may be links with n rooms

    public function residences()
    {
        return $this->hasMany(\App\Models\Residence::class);
    }
}
