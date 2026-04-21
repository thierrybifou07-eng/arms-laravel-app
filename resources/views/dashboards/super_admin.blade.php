<!-- Super Admin Dashboard Stats -->
<div class="card mb-4">
    <div class="d-flex align-items-start row">
        <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">Welcome {{ Auth::user()->firstname }}
                    {{ Auth::user()->lastname }}! 🎉</h5>
                <p class="mb-3">You are logged in as
                    <strong>{{ Auth::user()->roles->first()->label }}</strong>
                </p>
                <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                    <i class="icon-base bx bx-user me-1"></i> View Profile
                </a>
            </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-6">
                <img src="{{ asset('admin-template/assets/img/illustrations/man-with-laptop.png') }}" height="175"
                    alt="Welcome">
            </div>
        </div>
    </div>
</div>

<!-- Main KPIs Row -->
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ $dashboardData['totalStudents'] ?? 0 }}</h3>
                        <p class="text-muted mb-0 small">Total Students</p>
                    </div>
                    <div class="avatar bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="icon-base bx bx-user-circle text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ $dashboardData['totalContracts'] ?? 0 }}</h3>
                        <p class="text-muted mb-0 small">Total Contracts</p>
                        <small class="text-success"><i class="bx bx-check-circle me-1"></i>{{ $dashboardData['activeContracts'] ?? 0 }} Active</small>
                    </div>
                    <div class="avatar bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="icon-base bx bx-receipt text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ $dashboardData['totalPayments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0 small">Total Payments</p>
                        <small class="text-info"><i class="bx bx-check-circle me-1"></i>{{ $dashboardData['validatedPayments'] ?? 0 }} Valid</small>
                    </div>
                    <div class="avatar bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="icon-base bx bx-money text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ $dashboardData['totalAudits'] ?? 0 }}</h3>
                        <p class="text-muted mb-0 small">Audit Records</p>
                        <small class="text-warning"><i class="bx bx-calendar me-1"></i>{{ $dashboardData['todayAudits'] ?? 0 }} Today</small>
                    </div>
                    <div class="avatar bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="icon-base bx bx-git-branch text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Audit Statistics Cards -->
<div class="row mt-2">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="bx bx-history me-2"></i>Audit Activity Breakdown
                </h5>
                <a href="{{ route('super_adminaudits.index') }}" class="btn btn-sm btn-outline-primary">
                    View All Audits
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="p-3 rounded text-center">
                            <div class="mb-2">
                                <i class="bx bx-plus-circle text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="text-success mb-1">Created</h6>
                            <h4 class="mb-0">{{ $dashboardData['auditsByEvent']['created'] ?? 0 }}</h4>
                            <small class="text-muted">New records</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 rounded text-center">
                            <div class="mb-2">
                                <i class="bx bx-edit text-info" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="text-info mb-1">Updated</h6>
                            <h4 class="mb-0">{{ $dashboardData['auditsByEvent']['updated'] ?? 0 }}</h4>
                            <small class="text-muted">Modified records</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 rounded text-center">
                            <div class="mb-2">
                                <i class="bx bx-trash text-danger" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="text-danger mb-1">Deleted</h6>
                            <h4 class="mb-0">{{ $dashboardData['auditsByEvent']['deleted'] ?? 0 }}</h4>
                            <small class="text-muted">Removed records</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 rounded text-center">
                            <div class="mb-2">
                                <i class="bx bx-refresh text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="text-warning mb-1">Restored</h6>
                            <h4 class="mb-0">{{ $dashboardData['auditsByEvent']['restored'] ?? 0 }}</h4>
                            <small class="text-muted">Recovered records</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities Dashboard -->
<div class="row mt-2">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="bx bx-credit-card me-2"></i>Recent Payments</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>ID</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['recentPayments'] ?? [] as $payment)
                            <tr>
                                <td class="fw-bold">#{{ $payment->id }}</td>
                                <td>{{ $payment->contract?->user?->firstname ?? 'N/A' }}
                                    {{ $payment->contract?->user?->lastname ?? '' }}</td>
                                <td><strong>{{ number_format($payment->expected_amount ?? 0, 0, ',', ' ') }} DZD</strong></td>
                                <td>
                                    @if ($payment->isOverdue())
                                        <span class="badge bg-danger">Overdue</span>
                                    @else
                                        @switch($payment->status->code)
                                            @case('pending')
                                                <span class="badge bg-label-warning">{{ $payment->status->label }}</span>
                                            @break

                                            @case('validated')
                                                <span class="badge bg-label-success">{{ $payment->status->label }}</span>
                                            @break

                                            @case('cancelled')
                                                <span class="badge bg-label-secondary">{{ $payment->status->label }}</span>
                                            @break

                                            @case('processing')
                                                <span class="badge bg-label-info">{{ $payment->status->label }}</span>
                                            @break

                                            @default
                                                <span
                                                    class="badge bg-label-dark">{{ $payment->status->label ?? 'Unknown' }}</span>
                                        @endswitch
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $payment->created_at?->format('M d, Y') }}</small></td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">No recent payments</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="bx bx-git-compare me-2"></i>Recent Audits</h5>
                    <a href="{{ route('super_adminaudits.index') }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
                <div class="card-body p-0">
                    <div style="max-height: 400px; overflow-y: auto;">
                        @forelse($dashboardData['recentAudits'] ?? [] as $audit)
                            <div class="px-3 py-2 border-bottom d-flex align-items-start gap-2 hover-bg" style="transition: background-color 0.2s;">
                                <div class="flex-grow-1">
                                    <a href="{{ route('super_adminaudits.show', $audit) }}" class="text-decoration-none">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            @if ($audit->event === 'created')
                                                <span class="badge bg-success" style="font-size: 0.65rem;">Created</span>
                                            @elseif ($audit->event === 'updated')
                                                <span class="badge bg-info" style="font-size: 0.65rem;">Updated</span>
                                            @elseif ($audit->event === 'deleted')
                                                <span class="badge bg-danger" style="font-size: 0.65rem;">Deleted</span>
                                            @elseif ($audit->event === 'restored')
                                                <span class="badge bg-warning" style="font-size: 0.65rem;">Restored</span>
                                            @endif
                                            <small class="text-muted">{{ class_basename($audit->auditable_type) }}</small>
                                        </div>
                                        <small class="text-dark">ID #{{ $audit->auditable_id }}</small>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <small class="text-muted">{{ $audit->user?->firstname ?? 'System' }}</small>
                                            <small class="text-muted">{{ $audit->created_at->diffForHumans() }}</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3">
                                No audit records yet
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Contracts Recent Activities -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="bx bx-file-blank me-2"></i>Recent Contracts</h5>
                <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>Student</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                            <tr>
                                <td><strong>{{ $contract->user?->firstname ?? 'N/A' }} {{ $contract->user?->lastname ?? '' }}</strong></td>
                                <td>
                                    <small>
                                        {{ $contract->room?->floor?->building?->name ?? 'N/A' }} / 
                                        F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}
                                    </small>
                                </td>
                                <td>
                                    @switch($contract->status->code)
                                        @case('pending')
                                            <span class="badge bg-label-warning">{{ $contract->status->label }}</span>
                                        @break

                                        @case('active')
                                            <span class="badge bg-label-success">{{ $contract->status->label }}</span>
                                        @break

                                        @case('overdue')
                                            <span class="badge bg-danger">{{ $contract->status->label }}</span>
                                        @break

                                        @case('expired')
                                            <span class="badge bg-label-secondary">{{ $contract->status->label }}</span>
                                        @break

                                        @case('archived')
                                            <span class="badge bg-label-dark">{{ $contract->status->label }}</span>
                                        @break

                                        @default
                                            <span
                                                class="badge bg-label-danger">{{ $contract->status->label ?? 'Unknown' }}</span>
                                    @endswitch
                                </td>
                                <td><small class="text-muted">{{ $contract->created_at?->format('M d, Y') }}</small></td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">No contracts found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<style>
    .hover-bg:hover {
        background-color: rgba(0, 0, 0, 0.02);
        cursor: pointer;
    }
</style>
