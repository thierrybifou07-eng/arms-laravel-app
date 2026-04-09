# 💡 Exemples Pratiques d'Utilisation du Système d'Audit

## 1. Ajouter le Trait Auditable aux Modèles

### Exemple 1: Model Residence
```php
<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    use Auditable; // ← Ajouter cette ligne
    
    protected $fillable = ['name', 'address', 'city', 'postal_code'];

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
```

### Exemple 2: Model Contract
```php
<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use Auditable; // ← Ajouter cette ligne
    
    protected $fillable = ['resident_id', 'room_id', 'start_date', 'end_date', 'status'];

    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id');
    }
}
```

### Exemple 3: Model Payment
```php
<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Auditable; // ← Ajouter cette ligne
    
    protected $fillable = ['contract_id', 'amount', 'status', 'due_date', 'paid_at'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
```

## 2. Enregistrement Manuel d'Actions Personnalisées

### Exemple: Logger une exportation
```php
<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Payment;

class ReportController extends Controller
{
    public function exportPayments(Request $request)
    {
        $payments = Payment::all();
        
        // Logger l'exportation
        AuditLog::log(
            action: 'EXPORT',
            userId: auth()->id(),
            modelType: 'App\Models\Payment',
            modelId: null,
            details: "Export de {$payments->count()} paiements en CSV",
        );

        // Créer le CSV...
        return $this->generateCSV($payments);
    }
}
```

### Exemple: Logger une importation
```php
<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Payment;

class ImportController extends Controller
{
    public function importPayments(Request $request)
    {
        $file = $request->file('csv');
        $count = 0;

        // Import la données...
        
        // Logger l'importation
        AuditLog::log(
            action: 'IMPORT',
            userId: auth()->id(),
            modelType: 'App\Models\Payment',
            modelId: null,
            details: "Import de {$count} paiements depuis fichier CSV",
        );

        return back()->with('success', "{$count} paiements importés");
    }
}
```

### Exemple: Logger une action spéciale
```php
<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Contract;

class ContractController extends Controller
{
    public function approve(Contract $contract)
    {
        $oldStatus = $contract->status;
        $contract->update(['status' => 'approved']);

        // Logger manuellement pour plus de détails
        AuditLog::log(
            action: 'APPROVE',
            userId: auth()->id(),
            modelType: 'App\Models\Contract',
            modelId: $contract->id,
            oldValues: ['status' => $oldStatus],
            newValues: ['status' => 'approved'],
            details: "Contrat approuvé par super admin",
        );

        return back()->with('success', 'Contrat approuvé');
    }
}
```

## 3. Requêtes et Filtres Courants

### Voir tous les logs d'un utilisateur
```php
$userId = 5;
$logs = AuditLog::byUser($userId)->get();

foreach ($logs as $log) {
    echo "{$log->created_at}: {$log->action} - {$log->details}\n";
}
```

### Voir toutes les créations cette semaine
```php
$creations = AuditLog::byAction('CREATE')
    ->byDateRange(now()->subWeek(), now())
    ->get();
```

### Voir les modifications d'un modèle spécifique
```php
$contractChanges = AuditLog::byModelType('App\Models\Contract')
    ->byAction('UPDATE')
    ->latest()
    ->get();
```

### Rechercher dans les logs
```php
$results = AuditLog::search('Jean Dupont')->get();
$results = AuditLog::search('payment')->get();
```

### Voir l'historique complet d'un enregistrement
```php
$contractId = 123;
$history = AuditLog::where('model_type', 'App\Models\Contract')
    ->where('model_id', $contractId)
    ->orderBy('created_at', 'asc')
    ->with('user')
    ->get();

foreach ($history as $entry) {
    echo "[".$entry->created_at."] ";
    echo $entry->user?->firstname . " effectué ";
    echo $entry->action . "\n";
}
```

## 4. Affichage des Logs dans les Vues

### Tableau simple des logs
```blade
<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Utilisateur</th>
            <th>Action</th>
            <th>Détails</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    @if($log->user)
                        {{ $log->user->firstname }} {{ $log->user->lastname }}
                    @else
                        Système
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $log->action === 'DELETE' ? 'danger' : 'info' }}">
                        {{ $log->action }}
                    </span>
                </td>
                <td>{{ $log->details }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
```

### Affichage formaté avec changements
```blade
@foreach($logs as $log)
    <div class="card mb-2">
        <div class="card-body">
            <h6 class="card-title">
                {{ $log->created_at->format('d/m/Y H:i:s') }}
                <span class="badge bg-primary">{{ $log->action }}</span>
            </h6>
            
            <p class="text-muted">
                Par: {{ $log->user->firstname }} {{ $log->user->lastname }}
                <br/>
                IP: {{ $log->ip_address }}
            </p>
            
            @if($log->old_values && $log->new_values)
                <div class="bg-light p-2 rounded">
                    @foreach($log->new_values as $key => $newValue)
                        <div class="small">
                            <strong>{{ $key }}</strong>: 
                            <del>{{ $log->old_values[$key] ?? 'N/A' }}</del>
                            → 
                            <strong>{{ $newValue }}</strong>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endforeach
```

## 5. Affichage Conditionnel Selon le Rôle

### Dashboard Super Admin avec Audit Summary
```blade
@can('view-audit-logs')
<div class="card">
    <div class="card-header">
        <h5>Audit Summary</h5>
    </div>
    <div class="card-body">
        <p>Créations aujourd'hui: {{ $creationsToday }}</p>
        <p>Modifications aujourd'hui: {{ $updatesToday }}</p>
        <p>Suppressions aujourd'hui: {{ $deletesToday }}</p>
        <a href="{{ route('audit-logs.index') }}" class="btn btn-primary">
            Voir tous les logs
        </a>
    </div>
</div>
@endcan
```

### Widget dans le dashboard
```php
<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;

class DashboardController extends Controller
{
    public function index()
    {
        $creationsToday = AuditLog::byAction('CREATE')
            ->whereDate('created_at', today())
            ->count();
            
        $updatesToday = AuditLog::byAction('UPDATE')
            ->whereDate('created_at', today())
            ->count();
            
        $deletesToday = AuditLog::byAction('DELETE')
            ->whereDate('created_at', today())
            ->count();
        
        $recentLogs = AuditLog::latest()
            ->limit(10)
            ->with(['user', 'auditType'])
            ->get();

        return view('dashboard', compact(
            'creationsToday',
            'updatesToday', 
            'deletesToday',
            'recentLogs'
        ));
    }
}
```

## 6. Notifications et Alertes

### Envoyer une notification pour une action importante
```php
<?php

namespace App\Models;

use App\Traitsditable;
use App\Notifications\AuditActionNotification;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use Auditable;
    
    protected static function booted()
    {
        static::updated(function (self $contract) {
            if ($contract->isDirty('status')) {
                // Notifier les admins
                User::whereHas('roles', fn($q) => 
                    $q->where('name', 'super_admin')
                )->each(fn($admin) => 
                    $admin->notify(new AuditActionNotification($contract, 'updated'))
                );
            }
        });
    }
}
```

## 7. Rapports et Statistiques

### Rapport d'activité utilisateur
```php
<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditReportService
{
    public function userActivityReport($userId, $startDate, $endDate)
    {
        return AuditLog::byUser($userId)
            ->byDateRange($startDate, $endDate)
            ->get()
            ->groupBy(function($log) {
                return $log->action;
            })
            ->map(function($group) {
                return $group->count();
            });
    }

    public function modelChangeReport($modelType, $startDate, $endDate)
    {
        return AuditLog::byModelType($modelType)
            ->byDateRange($startDate, $endDate)
            ->get();
    }

    public function dailyActivityTrend($days = 30)
    {
        return AuditLog::where('created_at', '>=', now()->subDays($days))
            ->get()
            ->groupBy(function($log) {
                return $log->created_at->toDateString();
            })
            ->map(function($group) {
                return $group->count();
            });
    }
}
```

### Usage du service
```php
$service = new AuditReportService();

// Rapport d'un utilisateur
$report = $service->userActivityReport(
    userId: 5,
    startDate: '2026-04-01',
    endDate: '2026-04-30'
);

// Modifications des contrats ce mois-ci
$changes = $service->modelChangeReport(
    modelType: 'App\Models\Contract',
    startDate: '2026-04-01',
    endDate: '2026-04-30'
);

// Tendance d'activité (derniers 30 jours)
$trend = $service->dailyActivityTrend(30);

dd($report, $changes, $trend);
```

## 8. Middleware Personnalisé pour Audit Avancé

### Logger toutes les requêtes API
```php
<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;

class LogApiRequests
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if ($request->is('api/*')) {
            AuditLog::log(
                action: strtoupper($request->method()),
                userId: auth()->id(),
                details: $request->path() . ' - ' . $response->getStatusCode(),
            );
        }
    }
}
```

## 9. Tests Unitaires pour l'Audit

### Test: Créer avec Audit Log
```php
<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\AuditLog;
use Tests\TestCase;

class ContractAuditTest extends TestCase
{
    public function test_contract_creation_is_audited()
    {
        $initialCount = AuditLog::count();

        $contract = Contract::create([
            'resident_id' => 1,
            'room_id' => 1,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'active'
        ]);

        $this->assertEquals($initialCount + 1, AuditLog::count());

        $log = AuditLog::latest()->first();
        $this->assertEquals('CREATE', $log->action);
        $this->assertEquals('App\Models\Contract', $log->model_type);
        $this->assertEquals($contract->id, $log->model_id);
    }

    public function test_contract_update_is_audited()
    {
        $contract = Contract::factory()->create();
        $log = AuditLog::where('model_id', $contract->id)->delete();

        $contract->update(['status' => 'completed']);

        $log = AuditLog::latest()->first();
        $this->assertEquals('UPDATE', $log->action);
        $this->assertContains('status', array_keys($log->new_values));
    }
}
```

## 10. Export/Import Personnalisé

### Export audit logs as JSON
```php
<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;

class AuditExportController extends Controller
{
    public function exportJson(Request $request)
    {
        $query = AuditLog::with(['user', 'auditType']);

        if ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
        }

        $logs = $query->get()->map(function($log) {
            return [
                'id' => $log->id,
                'date' => $log->created_at,
                'user' => $log->user?->name,
                'action' => $log->action,
                'model' => $log->model_type,
                'ip' => $log->ip_address,
                'details' => $log->details,
            ];
        });

        return response()->json($logs, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
```

---

Ces exemples vous montrent comment utiliser le système d'audit de manière flexible et puissante!

Pour plus de détails, consultez [AUDIT_GUIDE.md](AUDIT_GUIDE.md)
