<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\BillingPeriod;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Residence;
use App\Models\Role;
use App\Models\Room;
use App\Models\User;
use App\Models\UserStatus;
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
        } elseif ($user->hasRole('student')) {
            $role = 'student';
            $dashboardData = $this->getStudentStats($user);
        }

        return view('dashboard', compact('role', 'dashboardData'));
    }

    private function getSuperAdminStats()
    {
        $userCountsByRole = [
            Role::SUPER_ADMIN => User::whereHas('roles', fn ($q) => $q->where('name', Role::SUPER_ADMIN))->count(),
            Role::ADMIN => User::whereHas('roles', fn ($q) => $q->where('name', Role::ADMIN))->count(),
            Role::STAFF => User::whereHas('roles', fn ($q) => $q->where('name', Role::STAFF))->count(),
            Role::STUDENT => User::whereHas('roles', fn ($q) => $q->where('name', Role::STUDENT))->count(),
        ];

        $userCountsByStatus = [
            UserStatus::ACTIVE => User::whereHas('userStatus', fn ($q) => $q->where('code', UserStatus::ACTIVE))->count(),
            UserStatus::PENDING => User::whereHas('userStatus', fn ($q) => $q->where('code', UserStatus::PENDING))->count(),
            UserStatus::DISABLED => User::whereHas('userStatus', fn ($q) => $q->where('code', UserStatus::DISABLED))->count(),
        ];

        return [
            'role' => 'super_admin',
            'totalUsers' => User::count(),
            'newUsersToday' => User::whereDate('created_at', now())->count(),
            'newUsersThisWeek' => User::where('created_at', '>=', now()->startOfWeek())->count(),
            'userCountsByRole' => $userCountsByRole,
            'userCountsByStatus' => $userCountsByStatus,
            'pendingUsers' => User::with(['roles', 'userStatus'])
                ->whereHas('userStatus', fn ($q) => $q->where('code', UserStatus::PENDING))
                ->latest()
                ->take(6)
                ->get(),
            'recentUsers' => User::with(['roles', 'userStatus'])->latest()->take(6)->get(),
            'totalAudits' => Audit::count(),
            'auditsByEvent' => [
                'created' => Audit::byEvent('created')->count(),
                'updated' => Audit::byEvent('updated')->count(),
                'deleted' => Audit::byEvent('deleted')->count(),
                'restored' => Audit::byEvent('restored')->count(),
            ],
            'auditsByModel' => Audit::query()
                ->selectRaw('auditable_type, count(*) as total')
                ->groupBy('auditable_type')
                ->orderByDesc('total')
                ->take(5)
                ->get(),
            'recentAudits' => Audit::with('user')->latest()->take(8)->get(),
            'todayAudits' => Audit::whereDate('created_at', now())->count(),
            'auditActorsToday' => Audit::whereDate('created_at', now())
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count('user_id'),
        ];
    }

    private function getAdminStats()
    {
        $user = Auth::user();
        $residences = $user->residences()->orderBy('name')->get();

        $totalStudents = $this->countManagedStudents($user);
        $activeStudents = $this->countManagedStudents($user, 'active');
        $totalContracts = Contract::query()->forManager($user)->count();
        $contractsByStatus = [
            'pending' => Contract::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'active' => Contract::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
            'overdue' => Contract::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'overdue'))->count(),
            'expired' => Contract::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'expired'))->count(),
            'archived' => Contract::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'archived'))->count(),
        ];

        $totalPayments = Payment::query()->forManager($user)->count();
        $paymentsByStatus = [
            'pending' => Payment::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'processing' => Payment::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'processing'))->count(),
            'validated' => Payment::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'validated'))->count(),
            'cancelled' => Payment::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'cancelled'))->count(),
        ];
        $roomStats = $this->getRoomStats($user);
        $validatedPaymentsThisMonth = Payment::query()
            ->forManager($user)
            ->whereHas('status', fn ($q) => $q->where('code', 'validated'))
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('paid_amount');
        $overduePayments = $this->countOverduePayments($user);

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
            'managedResidences' => $residences,
            'managedResidence' => $user->managedResidence(),
            'message' => $residences->isEmpty() ? 'No residence assigned yet.' : null,
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
            'validatedPaymentsThisMonth' => $validatedPaymentsThisMonth,
            'overduePayments' => $overduePayments,
            'totalPaymentHistories' => PaymentHistory::query()->forManager($user)->count(),
            'totalBillingPeriods' => BillingPeriod::count(),
            'roomStats' => $roomStats,
            'occupancyRate' => $this->calculateOccupancyRate($roomStats),
            'residenceStats' => $residenceStats,
            'recentPayments' => Payment::query()
                ->forManager($user)
                ->with(['contract.user', 'status'])
                ->whereHas('status', fn ($q) => $q->where('code', 'validated'))
                ->latest()
                ->take(5)
                ->get(),
            'recentContracts' => Contract::query()
                ->forManager($user)
                ->with(['user', 'room.floor.building.residence', 'status'])
                ->latest()
                ->take(5)
                ->get(),
        ];
    }

    private function getStaffStats()
    {
        $user = Auth::user();
        $managedResidence = $user->managedResidence();
        $roomStats = $this->getRoomStats($user);

        return [
            'role' => 'staff',
            'managedResidence' => $managedResidence,
            'message' => $managedResidence ? null : 'No residence assigned yet.',
            'totalStudents' => $this->countManagedStudents($user),
            'totalContracts' => Contract::query()->forManager($user)->count(),
            'activeContracts' => Contract::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
            'pendingContracts' => Contract::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'overdueContracts' => Contract::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'overdue'))->count(),
            'recentContracts' => Contract::query()
                ->forManager($user)
                ->with(['user', 'room.floor.building.residence', 'status'])
                ->latest()
                ->take(5)
                ->get(),
            'totalBillingPeriods' => BillingPeriod::count(),
            'totalPayments' => Payment::query()->forManager($user)->count(),
            'validatedPayments' => Payment::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'validated'))->count(),
            'pendingPayments' => Payment::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'processingPayments' => Payment::query()->forManager($user)->whereHas('status', fn ($q) => $q->where('code', 'processing'))->count(),
            'overduePayments' => $this->countOverduePayments($user),
            'totalPaymentHistories' => PaymentHistory::query()->forManager($user)->count(),
            'roomStats' => $roomStats,
            'occupancyRate' => $this->calculateOccupancyRate($roomStats),
            'recentHistories' => PaymentHistory::query()
                ->forManager($user)
                ->with(['payment.contract.user', 'recordedBy'])
                ->latest()
                ->take(5)
                ->get(),
            'recentPayments' => Payment::query()
                ->forManager($user)
                ->with(['contract.user', 'status'])
                ->latest()
                ->take(5)
                ->get(),
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
        $contracts = $user->contracts()->with(['status', 'room.floor.building.residence'])->latest()->get();

        if (! $contracts->count()) {
            return ['role' => 'student', 'message' => 'No contracts assigned'];
        }

        $payments = Payment::with(['method', 'status', 'contract.room.floor.building.residence'])
            ->whereHas('contract', fn ($q) => $q->where('user_id', $user->id))
            ->orderByDesc('due_date')
            ->get();
        $openPayments = $payments->filter(fn (Payment $payment) => ! in_array($payment->status?->code, ['validated', 'cancelled'], true));
        $nextPayment = $openPayments->sortBy('due_date')->first();
        $activeContract = $contracts->first(fn (Contract $contract) => $contract->status?->code === 'active');

        return [
            'role' => 'student',
            'studentName' => $user->firstname.' '.$user->lastname,
            'totalContracts' => $contracts->count(),
            'activeContracts' => $contracts->filter(fn ($c) => $c->status->code === 'active')->count(),
            'totalPayments' => $payments->count(),
            'paidPayments' => $payments->filter(fn ($p) => $p->status->code === 'validated')->count(),
            'PaidPayments' => $payments->filter(fn ($p) => $p->status->code === 'validated')->count(),
            'pendingPayments' => $payments->filter(fn ($p) => $p->status->code === 'pending')->count(),
            'processingPayments' => $payments->filter(fn ($p) => $p->status->code === 'processing')->count(),
            'overduePayments' => $payments->filter(fn (Payment $payment) => $payment->isOverdue())->count(),
            'outstandingBalance' => $openPayments->sum(fn (Payment $payment) => max(0, $payment->expected_amount - $payment->paid_amount)),
            'nextPayment' => $nextPayment,
            'activeContract' => $activeContract,
            'currentResidence' => $activeContract?->room?->floor?->building?->residence,
            'recentContracts' => $contracts,
            'payments' => $payments,
        ];
    }

    private function countManagedStudents(User $user, ?string $contractStatus = null): int
    {
        $studentIds = Contract::query()
            ->forManager($user)
            ->when($contractStatus, fn ($query) => $query->whereHas('status', fn ($statusQuery) => $statusQuery->where('code', $contractStatus)))
            ->select('user_id')
            ->distinct();

        return User::query()
            ->whereHas('roles', fn ($query) => $query->where('name', 'student'))
            ->whereIn('id', $studentIds)
            ->count();
    }

    private function getRoomStats(User $user): array
    {
        $rooms = Room::query()->forManager($user);

        return [
            'total' => (clone $rooms)->count(),
            'available' => (clone $rooms)->whereHas('status', fn ($query) => $query->where('code', 'available'))->count(),
            'busy' => (clone $rooms)->whereHas('status', fn ($query) => $query->where('code', 'busy'))->count(),
            'renew' => (clone $rooms)->whereHas('status', fn ($query) => $query->where('code', 'renew'))->count(),
            'closed' => (clone $rooms)->whereHas('status', fn ($query) => $query->where('code', 'closed'))->count(),
        ];
    }

    private function calculateOccupancyRate(array $roomStats): int
    {
        if (($roomStats['total'] ?? 0) === 0) {
            return 0;
        }

        return (int) round((($roomStats['busy'] ?? 0) + ($roomStats['renew'] ?? 0)) / $roomStats['total'] * 100);
    }

    private function countOverduePayments(User $user): int
    {
        return Payment::query()
            ->forManager($user)
            ->whereDate('due_date', '<', now())
            ->whereColumn('paid_amount', '<', 'expected_amount')
            ->whereDoesntHave('status', fn ($query) => $query->whereIn('code', ['validated', 'cancelled']))
            ->count();
    }
}
