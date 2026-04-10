<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Services\AuditExportService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuditController extends Controller
{
    protected AuditExportService $exportService;

    public function __construct(AuditExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of audits.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Audit::class);

        $query = Audit::query();

        // Filter by event
        if ($request->filled('event')) {
            $query->byEvent($request->event);
        }

        // Filter by auditable model
        if ($request->filled('model')) {
            $query->forModel($request->model);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }

        // Search in tags or URL
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tags', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            });
        }

        $audits = $query->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $models = $this->getAuditableModels();
        $events = ['created', 'updated', 'deleted', 'restored'];

        return view('super_admin.audits.index', compact('audits', 'models', 'events'));
    }

    /**
     * Show the audit detail.
     */
    public function show(Audit $audit)
    {
        $this->authorize('view', $audit);

        return view('super_admin.audits.show', compact('audit'));
    }

    /**
     * Delete an audit record.
     */
    public function destroy(Request $request, Audit $audit)
    {
        $this->authorize('delete', $audit);

        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $audit->delete();

        return redirect()
            ->route('super_admin.audits.index')
            ->with('success', 'Audit record deleted successfully.');
    }

    /**
     * Delete multiple audit records.
     */
    public function destroyMultiple(Request $request)
    {
        $this->authorize('deleteMultiple', Audit::class);

        $request->validate([
            'audit_ids' => ['required', 'array', 'min:1'],
            'audit_ids.*' => ['exists:audits,id'],
            'password' => ['required', 'current_password'],
        ]);

        Audit::whereIn('id', $request->audit_ids)->delete();

        return redirect()
            ->route('super_admin.audits.index')
            ->with('success', count($request->audit_ids) . ' audit records deleted successfully.');
    }

    /**
     * Export audits as CSV.
     */
    public function export(Request $request)
    {
        $this->authorize('export', Audit::class);

        $request->validate([
            'password' => ['required', 'current_password'],
            'format' => ['required', 'in:csv,excel'],
        ]);

        $query = Audit::query();

        // Apply same filters as index
        if ($request->filled('event')) {
            $query->byEvent($request->event);
        }

        if ($request->filled('model')) {
            $query->forModel($request->model);
        }

        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange($request->start_date, $request->end_date);
        }

        $audits = $query->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->format === 'csv') {
            return $this->exportService->exportCsv($audits);
        }

        return $this->exportService->exportExcel($audits);
    }

    /**
     * Get all auditable models that have audit records.
     */
    protected function getAuditableModels(): array
    {
        return Audit::distinct()
            ->pluck('auditable_type')
            ->map(fn ($model) => class_basename($model))
            ->sort()
            ->values()
            ->toArray();
    }
}
