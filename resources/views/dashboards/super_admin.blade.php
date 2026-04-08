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
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalStudents'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Students</p>
                    </div>
                    <i class="icon-base bx bx-user-circle text-primary" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalContracts'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Contracts <span
                                class="badge bg-success ms-2">{{ $dashboardData['activeContracts'] ?? 0 }}</span></p>
                    </div>
                    <i class="icon-base bx bx-receipt text-success" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalPayments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Payments <span
                                class="badge bg-info ms-2">{{ $dashboardData['validatedPayments'] ?? 0 }}</span></p>
                    </div>
                    <i class="icon-base bx bx-money text-info" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalBillingPeriods'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Billing Periods <span
                                class="badge bg-warning ms-2">{{ $dashboardData['activeBillingPeriods'] ?? 0 }}</span>
                        </p>
                    </div>
                    <i class="icon-base bx bx-calendar text-warning" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Audit Statistics Section -->
<div class="row mt-4 mb-4">
    <div class="col-12">
        <h5 class="mb-3">
            <i class="icon-base bx bx-history me-2"></i>Audit Logs Statistics
        </h5>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $dashboardData['auditStats']['totalLogs'] ?? 0 }}</h4>
                        <p class="text-muted mb-0 small">Total Audit Logs</p>
                    </div>
                    <i class="icon-base bx bx-database text-info" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $dashboardData['auditStats']['logsToday'] ?? 0 }}</h4>
                        <p class="text-muted mb-0 small">Logs Today</p>
                    </div>
                    <i class="icon-base bx bx-calendar-event text-primary" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $dashboardData['auditStats']['createsCount'] ?? 0 }}</h4>
                        <p class="text-muted mb-0 small">Create Actions</p>
                    </div>
                    <i class="icon-base bx bx-plus-circle text-success" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $dashboardData['auditStats']['updatesCount'] ?? 0 }}</h4>
                        <p class="text-muted mb-0 small">Update Actions</p>
                    </div>
                    <i class="icon-base bx bx-edit text-warning" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $dashboardData['auditStats']['deletesCount'] ?? 0 }}</h4>
                        <p class="text-muted mb-0 small">Delete Actions</p>
                    </div>
                    <i class="icon-base bx bx-trash text-danger" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $dashboardData['auditStats']['loginsCount'] ?? 0 }}</h4>
                        <p class="text-muted mb-0 small">Login Actions</p>
                    </div>
                    <i class="icon-base bx bx-log-in text-secondary" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $dashboardData['auditStats']['exportsCount'] ?? 0 }}</h4>
                        <p class="text-muted mb-0 small">Export Actions</p>
                    </div>
                    <i class="icon-base bx bx-download text-info" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light">
            <div class="card-body">
                <a href="{{ route('audit-logs.index') }}" class="btn btn-primary w-100">
                    <i class="icon-base bx bx-show me-1"></i>View All Logs
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Top Audited Users Section -->
@if(!empty($dashboardData['auditStats']['topUsers']))
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="icon-base bx bx-walk me-2"></i>Most Active Users (Audit)
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Actions Count</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['auditStats']['topUsers'] as $stat)
                            <tr>
                                <td>
                                    @if($stat->user)
                                        <strong>{{ $stat->user->firstname }} {{ $stat->user->lastname }}</strong>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $stat->user?->email ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $stat->total }}</span>
                                </td>
                                <td>
                                    @if($stat->user)
                                        <span class="badge bg-{{ $stat->user->userStatus?->code === 'active' ? 'success' : 'danger' }}">
                                            {{ $stat->user->userStatus?->label ?? 'Unknown' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Recent Audit Logs -->
@if(!empty($dashboardData['auditStats']['recentLogs']))
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="icon-base bx bx-history me-2"></i>Recent Audit Logs
                </h5>
                <a href="{{ route('audit-logs.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['auditStats']['recentLogs'] as $log)
                            <tr>
                                <td>
                                    <small class="text-muted">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </small>
                                </td>
                                <td>
                                    @if($log->user)
                                        <strong>{{ $log->user->firstname }} {{ $log->user->lastname }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $log->user->email }}</small>
                                    @else
                                        <span class="badge bg-secondary">System</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($log->action)
                                        @case('CREATE')
                                            <span class="badge bg-success">Create</span>
                                            @break
                                        @case('UPDATE')
                                            <span class="badge bg-info">Update</span>
                                            @break
                                        @case('DELETE')
                                            <span class="badge bg-danger">Delete</span>
                                            @break
                                        @case('LOGIN')
                                            <span class="badge bg-primary">Login</span>
                                            @break
                                        @case('LOGOUT')
                                            <span class="badge bg-warning">Logout</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $log->action }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <small>{{ Str::limit($log->details, 40) }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $log->ip_address }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">No audit logs yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Recent Activities -->
<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Recent Payments</h5>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['recentPayments'] ?? [] as $payment)
                            <tr>
                                <td>#{{ $payment->id }}</td>
                                <td>{{ $payment->contract?->user?->firstname ?? 'N/A' }}
                                    {{ $payment->contract?->user?->lastname ?? '' }}</td>
                                <td>{{ number_format($payment->expected_amount ?? 0, 0, ',', ' ') }} DZD</td>
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
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Aucun paiement</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Recent Contracts</h5>
                    <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="table-dark">
                                <th>Student</th>
                                <th>Room</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                                <tr>
                                    <td>{{ $contract->user?->firstname ?? 'N/A' }} {{ $contract->user?->lastname ?? '' }}
                                    </td>
                                    <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}
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
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">No contracts found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
