<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class ContractStatus extends Model
{
    use Auditable;

    protected $fillable = ['code', 'label'];

    public const PENDING = 'Pending';

    public const ACTIVE = 'Active';

    public const OVERDUE = 'Overdue';

    public const ARCHIVED = 'archived';

    public const EXPIRED = 'Expired';

    public const CANCELLED = 'Cancelled';

    // create the function(undefinded here) to call in the dbseeder

    public static function getIdByCode(string $code): ?int
    {
        return static::where('code', $code)->value('id');
    }

    public static function getIdByCodeOrFail(string $code): int
    {
        $record = static::where('code', $code)->first();

        if (! $record) {
            throw new \Exception("Code [$code] not found in ".static::class);
        }

        return $record->id;
    }

    // choose hasMany 'cause a status may be links with n contracts

    public function contracts()
    {
        return $this->hasMany(\App\Models\Contract::class);
    }
}
