<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditType extends Model
{
    protected $fillable = ['code', 'label'];

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
