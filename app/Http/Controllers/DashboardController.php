<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\BillingPeriod;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\User;
use App\Models\Residence;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = 'super_admin'; // default
        $dashboardData = [];

        if ($user->hasRole('super_admin')) {
            $role = 'super_admin';
            $dashboardData = $this->getSuperAdminStats();
        } elseif ($user->hasRole('admin')) {
            $role = 'admin';
            $dashboardData = $this->getAdminStats();
        } elseif ($user->hasRole('staff')) {
            $role = 'staff';
            $dashboardData = $this->getStaffStats();
        } elseif ($user->hasRole('teller')) {
            $role = 'teller';
            $dashboardData = $this->getTellerStats();
        } elseif ($user->hasRole('student')) {
            $role = 'student';
            $dashboardData = $this->getStudentStats($user);
        }

        return view('dashboard', compact('role', 'dashboardData'));
    }

    private function getSuperAdminStats()
    {
        // Audit statistics
        $auditStats = [
            'totalLogs' => AuditLog::count(),
            'logsToday' => AuditLog::whereDate('created_at', today())->count(),
            'createsCount' => AuditLog::where('action', 'CREATE')->count(),
            'updatesCount' => AuditLog::where('action', 'UPDATE')->count(),
            'deletesCount' => AuditLog::where('action', 'DELETE')->count(),
            'loginsCount' => AuditLog::where('action', 'LOGIN')->count(),
            'exportsCount' => AuditLog::where('action', 'EXPORT')->count(),
            'recentLogs' => AuditLog::with(['user', 'auditType'])->latest()->take(10)->get(),
            'topUsers' => AuditLog::selectRaw('user_id, count(*) as total')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->take(5)
                ->with('user')
                ->get(),
            'actionBreakdown' => AuditLog::selectRaw('action, count(*) as count')
                ->groupBy('action')
                ->get()
                ->mapWithKeys(fn($item) => [$item->action => $item->count]),
        ];

        return [
            'role' => 'super_admin',
            'totalStudents' => User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->count(),
            'totalContracts' => Contract::count(),
            'activeContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
            'pendingContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'totalPayments' => Payment::count(),
            'validatedPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'validated'))->count(),
            'pendingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'processingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'processing'))->count(),
            'totalPaymentHistories' => PaymentHistory::count(),
            'recentHistories' => PaymentHistory::latest()->take(5)->get(),
            'recentPayments' => Payment::with(['contract.user', 'status'])->latest()->take(10)->get(),
            'recentContracts' => Contract::with(['user', 'room', 'status'])->latest()->take(5)->get(),
            'auditStats' => $auditStats,
        ];
    }

    private function getAdminStats()
    {
        $user = Auth::user();
        $residences = $user->residences;
        
        // Stats globales
        $totalStudents = User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->count();
        $activeStudents = User::whereHas('roles', fn ($q) => $q->where('name', 'student'))
            ->whereHas('contracts', fn ($q) => $q->whereHas('status', fn ($s) => $s->where('code', 'active')))
            ->count();
        
        // Contract stats
        $totalContracts = Contract::count();
        $contractsByStatus = [
            'pending' => Contract::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'active' => Contract::whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
            'overdue' => Contract::whereHas('status', fn ($q) => $q->where('code', 'overdue'))->count(),
            'expired' => Contract::whereHas('status', fn ($q) => $q->where('code', 'expired'))->count(),
            'archived' => Contract::whereHas('status', fn ($q) => $q->where('code', 'archived'))->count(),
        ];
        
        // Payment stats
        $totalPayments = Payment::count();
        $paymentsByStatus = [
            'pending' => Payment::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'processing' => Payment::whereHas('status', fn ($q) => $q->where('code', 'processing'))->count(),
            'validated' => Payment::whereHas('status', fn ($q) => $q->where('code', 'validated'))->count(),
            'cancelled' => Payment::whereHas('status', fn ($q) => $q->where('code', 'cancelled'))->count(),
        ];
        
        // Residence statistics for each managed residence
        $residenceStats = [];
        foreach ($residences as $residence) {
            $monthlyPayments = $this->getMonthlyPaymentStats($residence);
            $residenceStats[] = [
                'residence' => $residence,
                'monthlyData' => $monthlyPayments,
                'totalAmount' => array_sum(array_column($monthlyPayments, 'amount')),
            ];
        }
        
        return [
            'role' => 'admin',
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'totalContracts' => $totalContracts,
            'contractsByStatus' => $contractsByStatus,
            'activeContracts' => $contractsByStatus['active'],
            'pendingContracts' => $contractsByStatus['pending'],
            'totalPayments' => $totalPayments,
            'paymentsByStatus' => $paymentsByStatus,
            'validatedPayments' => $paymentsByStatus['validated'],
            'pendingPayments' => $paymentsByStatus['pending'],
            'processingPayments' => $paymentsByStatus['processing'],
            'residenceStats' => $residenceStats,
            'recentPayments' => Payment::with(['contract.user', 'status'])->latest()->take(10)->get(),
            'recentContracts' => Contract::with(['user', 'room', 'status'])->latest()->take(5)->get(),
        ];
    }

    private function getStaffStats()
    {
        return [
            'role' => 'staff',
            'totalStudents' => User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->count(),
            'totalContracts' => Contract::count(),
            'activeContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
            'pendingContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'recentContracts' => Contract::with(['user', 'room', 'status'])->latest()->take(5)->get(),
            'totalBillingPeriods' => BillingPeriod::count(),
            'recentPayments' => Payment::with(['contract.user', 'status'])->latest()->take(10)->get(),
        ];
    }

    private function getTellerStats()
    {
        return [
            'role' => 'teller',
            'totalPayments' => Payment::count(),
            'validatedPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'validated'))->count(),
            'pendingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'processingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'processing'))->count(),
            'totalPaymentHistories' => PaymentHistory::count(),
            'recentHistories' => PaymentHistory::latest()->take(5)->get(),
            'recentPayments' => Payment::with(['contract.user', 'status'])->latest()->take(10)->get(),
        ];
    }

    /**
     * Get monthly payment statistics for a residence over the last 12 months
     */
    private function getMonthlyPaymentStats(Residence $residence)
    {
        $monthlyData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('m');
            $year = $date->format('Y');
            $monthLabel = $date->format('M Y');
            
            $amount = Payment::whereHas('contract.room.floor.building', function ($q) use ($residence) {
                    $q->where('residence_id', $residence->id);
                })
                ->whereHas('status', fn ($q) => $q->where('code', 'validated'))
                ->whereMonth('payment_date', $month)
                ->whereYear('payment_date', $year)
                ->sum('paid_amount');
            
            $monthlyData[] = [
                'month' => $monthLabel,
                'monthNum' => $month,
                'year' => $year,
                'amount' => (float) ($amount ?? 0),
            ];
        }
        
        return $monthlyData;
    }

    private function getStudentStats($user)
    {
        $contracts = $user->contracts;

        if (! $contracts->count()) {
            return ['role' => 'student', 'message' => 'No contracts assigned'];
        }

        $payments = Payment::with('method')->whereHas('contract', fn ($q) => $q->where('user_id', $user->id))->get();

        return [
            'role' => 'student',
            'studentName' => $user->firstname . ' ' . $user->lastname,
            'totalContracts' => $contracts->count(),
            'activeContracts' => $contracts->filter(fn ($c) => $c->status->code === 'active')->count(),
            'totalPayments' => $payments->count(),
            'PaidPayments' => $payments->filter(fn ($p) => $p->status->code === 'validated')->count(),
            'pendingPayments' => $payments->filter(fn ($p) => $p->status->code === 'pending')->count(),
            'recentContracts' => $contracts,
            'payments' => $payments,
        ];
    }
}
