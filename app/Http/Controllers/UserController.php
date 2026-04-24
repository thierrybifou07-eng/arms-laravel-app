<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Room;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles', 'userStatus');

        // Filtre by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filtre by status
        if ($request->filled('status')) {
            $query->whereHas('userStatus', function ($q) use ($request) {
                $q->where('code', $request->status);
            });
        }

        // (multi-column groups search)
        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Pagination avec conservation des paramètres GET
        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('super_admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load([
            'roles.permissions',
            'userStatus',
            'residences.status',
            'contracts.status',
            'contracts.room.floor.building.residence',
        ]);

        $userRole = $user->getRole();
        $statusOptions = UserStatus::query()->orderBy('label')->get();
        $roleInsights = $this->buildRoleInsights($user, $userRole?->name);
        $rolePanelView = match ($userRole?->name) {
            Role::SUPER_ADMIN,
            Role::ADMIN,
            Role::STAFF,
            Role::STUDENT => $userRole->name,
            default => 'default',
        };

        return view('super_admin.users.show', compact(
            'user',
            'userRole',
            'statusOptions',
            'roleInsights',
            'rolePanelView',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, User $user) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, User $user)
    {
        // Prevent user from modifying themselves
        if (auth()->id() === $user->id) {
            throw ValidationException::withMessages([
                'security' => 'You cannot modify your own profile from this section.',
            ]);
        }

        $validated = $request->validate([
            'firstname' => ['string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:25', 'unique:users,phone,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user)->with('success', 'User successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if (auth()->id() === $user->id) {
            throw ValidationException::withMessages([
                'security' => 'You cannot delete your own account.',
            ]);
        }

        // Prevent deletion of active users
        if ($user->userStatus?->code === UserStatus::ACTIVE) {
            throw ValidationException::withMessages([
                'status' => 'Cannot delete users with active status. Change their status to disabled first.',
            ]);
        }

        // Prevent deletion of super admins
        if ($user->hasRole(Role::SUPER_ADMIN)) {
            throw ValidationException::withMessages([
                'role' => 'Cannot delete super admin users.',
            ]);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User successfully deleted');
    }

    /**
     * Change user status (for admin only)
     */
    public function changeStatus(Request $request, User $user)
    {
        // Prevent user from changing their own status
        if (auth()->id() === $user->id) {
            throw ValidationException::withMessages([
                'security' => 'You cannot change your own status.',
            ]);
        }

        $validated = $request->validate([
            'user_status_id' => ['required', 'exists:user_statuses,id'],
        ]);

        // Prevent changing super admin status
        if ($user->hasRole(Role::SUPER_ADMIN)) {
            throw ValidationException::withMessages([
                'role' => 'Cannot change super admin user status.',
            ]);
        }

        $user->update([
            'user_status_id' => $validated['user_status_id'],
        ]);

        $statusLabel = UserStatus::find($validated['user_status_id'])?->label ?? 'Unknown';

        return redirect()->route('users.show', $user)->with('success', "User status changed to {$statusLabel}");
    }

    private function buildRoleInsights(User $user, ?string $roleName): array
    {
        return match ($roleName) {
            Role::SUPER_ADMIN => $this->buildSuperAdminInsights($user),
            Role::ADMIN => $this->buildAdminInsights($user),
            Role::STAFF => $this->buildStaffInsights($user),
            Role::STUDENT => $this->buildStudentInsights($user),
            default => $this->buildDefaultInsights($user),
        };
    }

    private function buildSuperAdminInsights(User $user): array
    {
        $auditQuery = Audit::query()->byUser($user->id);
        $recentAudits = (clone $auditQuery)->latest()->take(5)->get();
        $managedResidences = $user->residences->sortBy('name')->values();

        return [
            'scope_label' => 'Platform-wide access',
            'scope_description' => 'This account can oversee every module and is protected from destructive actions.',
            'stats' => [
                ['label' => 'Audit events', 'value' => (clone $auditQuery)->count(), 'icon' => 'bx-shield-quarter'],
                ['label' => 'Assigned residences', 'value' => $managedResidences->count(), 'icon' => 'bx-building-house'],
                ['label' => 'Permissions', 'value' => $user->getRole()?->permissions->count() ?? 0, 'icon' => 'bx-key'],
                ['label' => 'Personal contracts', 'value' => $user->contracts->count(), 'icon' => 'bx-file'],
            ],
            'recent_audits' => $recentAudits,
            'managed_residences' => $managedResidences,
        ];
    }

    private function buildAdminInsights(User $user): array
    {
        $managedResidences = $user->residences->sortBy('name')->values();
        $contractsQuery = Contract::query()->forManager($user);
        $paymentsQuery = Payment::query()->forManager($user);
        $roomsQuery = Room::query()->forManager($user);

        $managedStudentIds = Contract::query()
            ->forManager($user)
            ->select('user_id')
            ->distinct();

        $activeManagedStudentIds = Contract::query()
            ->forManager($user)
            ->whereHas('status', fn ($query) => $query->where('code', 'active'))
            ->select('user_id')
            ->distinct();

        $recentContracts = (clone $contractsQuery)
            ->with(['user', 'room.floor.building.residence', 'status'])
            ->latest()
            ->take(5)
            ->get();

        return [
            'scope_label' => 'Residence portfolio manager',
            'scope_description' => 'This admin supervises users, residences, resident contracts and payment flow',
            'stats' => [
                ['label' => 'Residences', 'value' => $managedResidences->count(), 'icon' => 'bx-building-house'],
                ['label' => 'Managed students', 'value' => User::query()->whereHas('roles', fn ($query) => $query->where('name', Role::STUDENT))->whereIn('id', $managedStudentIds)->count(), 'icon' => 'bx-group'],
                ['label' => 'Active contracts', 'value' => (clone $contractsQuery)->whereHas('status', fn ($query) => $query->where('code', 'active'))->count(), 'icon' => 'bx-receipt'],
                ['label' => 'Overdue payments', 'value' => $this->countOverduePayments($user), 'icon' => 'bx-error-circle'],
            ],
            'managed_residences' => $managedResidences,
            'residence_summary' => [
                'rooms_total' => (clone $roomsQuery)->count(),
                'rooms_busy' => (clone $roomsQuery)->whereHas('status', fn ($query) => $query->where('code', 'busy'))->count(),
                'active_students' => User::query()->whereHas('roles', fn ($query) => $query->where('name', Role::STUDENT))->whereIn('id', $activeManagedStudentIds)->count(),
                'validated_payments_this_month' => (clone $paymentsQuery)
                    ->whereHas('status', fn ($query) => $query->where('code', 'validated'))
                    ->whereMonth('payment_date', now()->month)
                    ->whereYear('payment_date', now()->year)
                    ->sum('paid_amount'),
            ],
            'recent_contracts' => $recentContracts,
        ];
    }

    private function buildStaffInsights(User $user): array
    {
        $assignedResidences = $user->residences->sortBy('name')->values();
        $contractsQuery = Contract::query()->forManager($user);
        $paymentsQuery = Payment::query()->forManager($user);

        $recentPayments = (clone $paymentsQuery)
            ->with(['contract.user', 'status'])
            ->latest()
            ->take(5)
            ->get();

        return [
            'scope_label' => 'Operational residence support',
            'scope_description' => 'This staff member follows day-to-day operations across the assigned residences and resident payment activity.',
            'stats' => [
                ['label' => 'Assigned residences', 'value' => $assignedResidences->count(), 'icon' => 'bx-map'],
                ['label' => 'Active contracts', 'value' => (clone $contractsQuery)->whereHas('status', fn ($query) => $query->where('code', 'active'))->count(), 'icon' => 'bx-file'],
                ['label' => 'Pending contracts', 'value' => (clone $contractsQuery)->whereHas('status', fn ($query) => $query->where('code', 'pending'))->count(), 'icon' => 'bx-time-five'],
                ['label' => 'Payments to review', 'value' => (clone $paymentsQuery)->whereDoesntHave('status', fn ($query) => $query->whereIn('code', ['validated', 'cancelled']))->count(), 'icon' => 'bx-wallet'],
            ],
            'managed_residences' => $assignedResidences,
            'recent_payments' => $recentPayments,
        ];
    }

    private function buildStudentInsights(User $user): array
    {
        $paymentsQuery = Payment::query()
            ->whereHas('contract', fn ($query) => $query->where('user_id', $user->id));

        $payments = (clone $paymentsQuery)
            ->with(['status', 'method', 'contract.room.floor.building.residence'])
            ->orderBy('due_date')
            ->get();

        $recentPayments = (clone $paymentsQuery)
            ->with(['status', 'method', 'contract.room.floor.building.residence'])
            ->latest()
            ->take(5)
            ->get();

        $activeContract = $user->contracts->first(fn ($contract) => $contract->status?->code === 'active');
        $openPayments = $payments->filter(
            fn (Payment $payment) => ! in_array($payment->status?->code, ['validated', 'cancelled'], true)
        );

        return [
            'scope_label' => 'Resident account',
            'scope_description' => 'This profile focuses on accommodation and upcoming payment obligations.',
            'stats' => [
                ['label' => 'Contracts', 'value' => $user->contracts->count(), 'icon' => 'bx-file'],
                ['label' => 'Open payments', 'value' => $openPayments->count(), 'icon' => 'bx-credit-card'],
                ['label' => 'Outstanding balance', 'value' => number_format($openPayments->sum(fn (Payment $payment) => max(0, $payment->expected_amount - $payment->paid_amount)), 0, ',', ' ').' FCFA', 'icon' => 'bx-money'],
                ['label' => 'Current residence', 'value' => $activeContract?->room?->floor?->building?->residence?->name ?? 'Not assigned', 'icon' => 'bx-home'],
            ],
            'active_contract' => $activeContract,
            'recent_payments' => $recentPayments,
            'next_payment' => $openPayments->sortBy('due_date')->first(),
        ];
    }

    private function buildDefaultInsights(User $user): array
    {
        return [
            'scope_label' => 'Role not assigned',
            'scope_description' => 'Assign a role to unlock the right management tools and dashboards for this account.',
            'stats' => [
                ['label' => 'Residences', 'value' => $user->residences->count(), 'icon' => 'bx-building-house'],
                ['label' => 'Contracts', 'value' => $user->contracts->count(), 'icon' => 'bx-file'],
                ['label' => 'Status', 'value' => $user->userStatus?->label ?? 'Unknown', 'icon' => 'bx-user-check'],
                ['label' => 'Email verified', 'value' => $user->email_verified_at ? 'Yes' : 'No', 'icon' => 'bx-envelope'],
            ],
        ];
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
