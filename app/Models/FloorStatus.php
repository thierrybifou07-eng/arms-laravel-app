<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class FloorStatus extends Model
{
    use Auditable;

    protected $fillable = ['code', 'label'];

    public const ACTIVE = 'active';

    public const CLOSED = 'closed';

    public const RENEW = 'renew';

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

    // choose hasMany 'cause a status may be links with n floors

    public function floors()
    {
        return $this->hasMany(\App\Models\Floor::class);
    }
}
