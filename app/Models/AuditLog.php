<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'audits';

    protected $fillable = [
        'user_id',
        'audit_type_id',
        'auditable_type',
        'auditable_id',
        'model_type',
        'model_id',
        'action',
        'details',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'method',
        'url',
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the audit type
     */
    public function auditType(): BelongsTo
    {
        return $this->belongsTo(AuditType::class);
    }

    /**
     * Scope: Filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by action type
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope: Filter by model type
     */
    public function scopeByModelType($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope: Search in details
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('details', 'like', "%{$search}%")
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
    }

    /**
     * Get the changed values as a formatted string
     */
    public function getChangedValuesAttribute(): string
    {
        if (!$this->old_values && !$this->new_values) {
            return 'N/A';
        }

        $changes = [];

        if ($this->old_values && $this->new_values) {
            foreach ($this->new_values as $key => $newValue) {
                $oldValue = $this->old_values[$key] ?? 'N/A';
                $changes[] = "{$key}: {$oldValue} → {$newValue}";
            }
        }

        return implode(', ', $changes);
    }

    /**
     * Get formatted model name
     */
    public function getFormattedModelAttribute(): string
    {
        return str_replace('\\', ' → ', $this->model_type) ?? $this->auditable_type;
    }

    /**
     * Log an action
     */
    public static function log(
        string $action,
        ?int $userId = null,
        string $modelType = '',
        ?int $modelId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        string $details = '',
        ?int $auditTypeId = null
    ): void {
        try {
            self::create([
                'user_id' => $userId ?? auth()->id(),
                'audit_type_id' => $auditTypeId ?? self::getAuditTypeId($action),
                'model_type' => $modelType,
                'model_id' => $modelId,
                'action' => $action,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'details' => $details,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'method' => request()->method(),
                'url' => request()->fullUrl(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error logging audit: ' . $e->getMessage());
        }
    }

    /**
     * Get audit type ID by action
     */
    private static function getAuditTypeId(string $action): int
    {
        $actionMap = [
            'CREATE' => 'create',
            'UPDATE' => 'update',
            'DELETE' => 'delete',
            'READ' => 'read',
            'LOGIN' => 'login',
            'LOGOUT' => 'logout',
            'DOWNLOAD' => 'download',
        ];

        $code = $actionMap[strtoupper($action)] ?? 'other';
        $auditType = AuditType::where('code', $code)->first();

        return $auditType?->id ?? 1;
    }
}
