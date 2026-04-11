<?php

namespace App\Models;

use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    /**
     * Get the user that made the audit.
     */
    public function user()
    {
        return $this->morphTo();
    }

    /**
     * Get the auditable model.
     */
    public function auditable()
    {
        return $this->morphTo();
    }

    /**
     * Scope to get user audits only.
     */
    public function scopeUserAudits($query)
    {
        return $query->where('event', 'created')
            ->orWhere('event', 'updated')
            ->orWhere('event', 'deleted')
            ->orWhere('event', 'restored');
    }

    /**
     * Scope to filter by auditable model.
     */
    public function scopeForModel($query, string $modelType)
    {
        return $query->where('auditable_type', $modelType);
    }

    /**
     * Scope to filter by event type.
     */
    public function scopeByEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope to filter by user.
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId)
            ->where('user_type', User::class);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get human-readable event label.
     */
    public function getEventLabelAttribute(): string
    {
        return match ($this->event) {
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'restored' => 'Restored',
            default => ucfirst($this->event),
        };
    }

    /**
     * Get the model name from the auditable_type.
     */
    public function getModelNameAttribute(): string
    {
        return class_basename($this->auditable_type);
    }
}
