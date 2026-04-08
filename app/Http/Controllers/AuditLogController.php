<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\AuditType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display audit logs
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', AuditLog::class);

        $query = AuditLog::with(['user', 'auditType'])
            ->orderBy('created_at', 'desc');

        // Filter by action
        if ($request->filled('action')) {
            $query->byAction($request->action);
        }

        // Filter by audit type
        if ($request->filled('audit_type')) {
            $query->where('audit_type_id', $request->audit_type);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->byModelType($request->model_type);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange(
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            );
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $auditLogs = $query->paginate(50);

        $auditTypes = AuditType::all();
        $actions = ['CREATE', 'UPDATE', 'DELETE', 'READ', 'LOGIN', 'LOGOUT', 'DOWNLOAD'];
        $modelTypes = AuditLog::distinct('model_type')->pluck('model_type');

        return view('audit-logs.index', compact(
            'auditLogs',
            'auditTypes',
            'actions',
            'modelTypes'
        ));
    }

    /**
     * Show single audit log details
     */
    public function show(AuditLog $auditLog): View
    {
        $this->authorize('view', $auditLog);

        return view('audit-logs.show', compact('auditLog'));
    }

    /**
     * Export audit logs
     */
    public function export(Request $request)
    {
        $this->authorize('viewAny', AuditLog::class);

        $query = AuditLog::with(['user', 'auditType']);

        // Appliquer les mêmes filtres
        if ($request->filled('action')) {
            $query->byAction($request->action);
        }

        if ($request->filled('audit_type')) {
            $query->where('audit_type_id', $request->audit_type);
        }

        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        if ($request->filled('model_type')) {
            $query->byModelType($request->model_type);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange(
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            );
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $logs = $query->get();

        $filename = 'audit-logs-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Date',
                'Utilisateur',
                'Action',
                'Type',
                'Détails',
                'Adresse IP',
                'Méthode HTTP',
                'URL',
            ]);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    optional($log->user)->firstname . ' ' . optional($log->user)->lastname,
                    $log->action,
                    $log->auditType?->label ?? 'N/A',
                    $log->details,
                    $log->ip_address,
                    $log->method,
                    $log->url,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Delete audit logs (with password confirmation)
     */
    public function destroy(Request $request)
    {
        $this->authorize('delete', AuditLog::class);

        $request->validate([
            'password' => 'required|string',
        ]);

        // Verify password
        if (!\Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }

        // Delete based on filters
        $query = AuditLog::query();

        if ($request->filled('days_old')) {
            $daysOld = (int) $request->days_old;
            $query->where('created_at', '<', now()->subDays($daysOld));
        }

        $deleted = $query->delete();

        return back()->with('success', "Logs deleted successfully ({$deleted} entries).");
    }

    /**
     * Clear all audit logs (super-admin only)
     */
    public function clear(Request $request)
    {
        $this->authorize('deleteAll', AuditLog::class);

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!\Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }

        $count = AuditLog::count();
        AuditLog::truncate();

        return back()->with('success', "All audit logs have been deleted ({$count} entries).");
    }
}
