<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    use Auditable;

    protected $fillable = ['code', 'label'];

    public const PENDING = 'pending';

    public const ACTIVE = 'active';

    public const DISABLED = 'disabled';

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

    // choose hasMany 'cause a status may be links with n users

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
