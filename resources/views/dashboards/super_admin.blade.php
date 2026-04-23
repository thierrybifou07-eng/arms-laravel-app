<div class="card mb-4">
    <div class="d-flex align-items-start row">
        <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">Welcome {{ Auth::user()->firstname }}
                    {{ Auth::user()->lastname }}!</h5>
                <p class="mb-3">
                    System workspace for user administration and audit log monitoring.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">
                        <i class="icon-base bx bx-user me-1"></i> Manage Users
                    </a>
                    <a href="{{ route('super_adminaudits.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="icon-base bx bx-history me-1"></i> Audit Logs
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-6">
                <img src="{{ asset('admin-template/assets/img/illustrations/man-with-laptop.png') }}" height="175"
                    alt="System dashboard">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ $dashboardData['totalUsers'] ?? 0 }}</h3>
                        <p class="text-muted mb-0 small">Total Users</p>
                        <small class="text-success">{{ $dashboardData['newUsersThisWeek'] ?? 0 }} new this week</small>
                    </div>
                    <div class="avatar bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="icon-base bx bx-group text-primary" style="font-size: 2rem;"></i>
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
                        <h3 class="mb-0">{{ $dashboardData['userCountsByStatus']['pending'] ?? 0 }}</h3>
                        <p class="text-muted mb-0 small">Pending Users</p>
                        <small class="text-warning">Awaiting activation</small>
                    </div>
                    <div class="avatar bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="icon-base bx bx-user-plus text-warning" style="font-size: 2rem;"></i>
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
                        <small class="text-info">{{ $dashboardData['todayAudits'] ?? 0 }} today</small>
                    </div>
                    <div class="avatar bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="icon-base bx bx-history text-info" style="font-size: 2rem;"></i>
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
                        <h3 class="mb-0">{{ $dashboardData['auditActorsToday'] ?? 0 }}</h3>
                        <p class="text-muted mb-0 small">Active Actors</p>
                        <small class="text-muted">Users audited today</small>
                    </div>
                    <div class="avatar bg-secondary bg-opacity-10 rounded-circle p-3">
                        <i class="icon-base bx bx-fingerprint text-secondary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Users by Role</h5>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary">View users</a>
            </div>
            <div class="card-body">
                @php
                    $roleLabels = [
                        'super_admin' => 'Super Admin',
                        'admin' => 'Admin',
                        'staff' => 'Staff',
                        'student' => 'Student',
                    ];
                @endphp
                @foreach ($roleLabels as $roleCode => $roleLabel)
                    @php
                        $count = $dashboardData['userCountsByRole'][$roleCode] ?? 0;
                        $total = max((int) ($dashboardData['totalUsers'] ?? 0), 1);
                        $percentage = round(($count / $total) * 100);
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-medium">{{ $roleLabel }}</span>
                            <span class="text-muted">{{ $count }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" style="width: {{ $percentage }}%;" role="progressbar"
                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Audit Events</h5>
                <a href="{{ route('super_adminaudits.index') }}" class="btn btn-sm btn-outline-primary">View logs</a>
            </div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-6 col-md-3">
                        <i class="icon-base bx bx-plus-circle text-success mb-2" style="font-size: 2rem;"></i>
                        <h5 class="mb-0">{{ $dashboardData['auditsByEvent']['created'] ?? 0 }}</h5>
                        <small class="text-muted">Created</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <i class="icon-base bx bx-edit text-info mb-2" style="font-size: 2rem;"></i>
                        <h5 class="mb-0">{{ $dashboardData['auditsByEvent']['updated'] ?? 0 }}</h5>
                        <small class="text-muted">Updated</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <i class="icon-base bx bx-trash text-danger mb-2" style="font-size: 2rem;"></i>
                        <h5 class="mb-0">{{ $dashboardData['auditsByEvent']['deleted'] ?? 0 }}</h5>
                        <small class="text-muted">Deleted</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <i class="icon-base bx bx-refresh text-warning mb-2" style="font-size: 2rem;"></i>
                        <h5 class="mb-0">{{ $dashboardData['auditsByEvent']['restored'] ?? 0 }}</h5>
                        <small class="text-muted">Restored</small>
                    </div>
                </div>

                <hr>

                <h6 class="mb-3">Most Audited Models</h6>
                @forelse ($dashboardData['auditsByModel'] ?? [] as $modelAudit)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ class_basename($modelAudit->auditable_type) }}</span>
                        <span class="badge bg-label-secondary">{{ $modelAudit->total }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">No audit activity yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Pending Users</h5>
                <a href="{{ route('activate_accountpending_users.index') }}" class="btn btn-sm btn-primary">Review</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>User</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dashboardData['pendingUsers'] ?? [] as $pendingUser)
                            <tr>
                                <td>
                                    <a href="{{ route('activate_accountpending_users.show', $pendingUser) }}"
                                        class="text-decoration-none fw-medium">
                                        {{ $pendingUser->firstname }} {{ $pendingUser->lastname }}
                                    </a>
                                    <div class="text-muted small">{{ $pendingUser->email }}</div>
                                </td>
                                <td>{{ $pendingUser->getRoleLabel() ?? 'Not assigned' }}</td>
                                <td>{{ $pendingUser->created_at?->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">No pending users</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Recent Audit Logs</h5>
                <a href="{{ route('super_adminaudits.index') }}" class="btn btn-sm btn-primary">Open logs</a>
            </div>
            <div class="card-body p-0">
                @forelse ($dashboardData['recentAudits'] ?? [] as $audit)
                    <a href="{{ route('super_adminaudits.show', $audit) }}"
                        class="d-flex align-items-start justify-content-between gap-3 px-4 py-3 border-bottom text-decoration-none">
                        <div>
                            <div class="fw-medium text-dark">{{ $audit->event_label }} {{ $audit->model_name }}</div>
                            <small class="text-muted">
                                {{ $audit->user?->firstname ?? 'System' }}
                                {{ $audit->user?->lastname ?? '' }}
                            </small>
                        </div>
                        <small class="text-muted text-nowrap">{{ $audit->created_at?->diffForHumans() }}</small>
                    </a>
                @empty
                    <div class="text-center text-muted py-3">No audit records yet</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
