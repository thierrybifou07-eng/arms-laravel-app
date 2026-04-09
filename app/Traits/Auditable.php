<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    /**
     * Boot the Auditable trait
     */
    public static function bootAuditable()
    {
        // Log when creating
        static::created(function (Model $model) {
            self::logModelActivity('CREATE', $model, null, $model->getAttributes());
        });

        // Log when updating
        static::updating(function (Model $model) {
            $original = $model->getOriginal();
            $changes = $model->getChanges();

            // Comparer pour obtenir uniquement les changements
            $oldValues = [];
            $newValues = [];

            foreach ($changes as $key => $newValue) {
                if (isset($original[$key])) {
                    $oldValues[$key] = $original[$key];
                    $newValues[$key] = $newValue;
                }
            }

            if (!empty($newValues)) {
                self::logModelActivity('UPDATE', $model, $oldValues, $newValues);
            }
        });

        // Log when deleting
        static::deleted(function (Model $model) {
            self::logModelActivity('DELETE', $model, $model->getAttributes(), null);
        });
    }

    /**
     * Log model activity
     */
    private static function logModelActivity(
        string $action,
        Model $model,
        ?array $oldValues,
        ?array $newValues
    ): void {
        // Éviter de logger certains modèles sensibles
        $excludedModels = [];

        $modelType = get_class($model);

        if (in_array($modelType, $excludedModels)) {
            return;
        }

        try {
            $details = ucfirst($action) . ' ' . class_basename($modelType);

            if ($action === 'UPDATE' && $oldValues && $newValues) {
                $details .= ' - ' . implode(', ', array_keys($newValues));
            }

            AuditLog::log(
                action: $action,
                userId: auth()->id(),
                modelType: $modelType,
                modelId: $model->id ?? null,
                oldValues: $oldValues,
                newValues: $newValues,
                details: $details,
            );
        } catch (\Exception $e) {
            \Log::error('Audit trait error: ' . $e->getMessage());
        }
    }
}
