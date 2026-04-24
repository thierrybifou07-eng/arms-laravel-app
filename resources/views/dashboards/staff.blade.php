<!-- Staff Dashboard -->
<div class="card mb-4">
    <div class="d-flex align-items-start row">
        <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">Welcome {{ Auth::user()->firstname }}
                    {{ Auth::user()->lastname }}! 🎉</h5>
                <p class="mb-3">You are logged in as
                    <strong>{{ Auth::user()->roles->first()->label }}</strong>
                </p>
                @if (!empty($dashboardData['managedResidence']))
                    <p class="mb-3">
                        Assigned residence:
                        <strong>{{ $dashboardData['managedResidence']->name }}</strong>
                    </p>
                @elseif (!empty($dashboardData['message']))
                    <div class="alert alert-warning py-2 mb-3">{{ $dashboardData['message'] }}</div>
                @endif
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
    <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
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
    <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['activeContracts'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Contracts <span
                                class="badge bg-warning ms-2">{{ $dashboardData['pendingContracts'] ?? 0 }}</span></p>
                    </div>
                    <i class="icon-base bx bx-receipt text-success" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['pendingPayments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Payments <span
                                class="badge bg-info ms-2">{{ $dashboardData['processingPayments'] ?? 0 }}</span><span
                                class="badge bg-success ms-2">{{ $dashboardData['validatedPayments'] ?? 0 }}</span></p>
                    </div>
                    <i class="icon-base bx bx-money text-success" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <small class="text-muted d-block mb-1">Occupancy</small>
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">{{ $dashboardData['occupancyRate'] ?? 0 }}%</h3>
                    <i class="icon-base bx bx-bed text-primary" style="font-size: 2rem;"></i>
                </div>
                <div class="progress mt-3" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ $dashboardData['occupancyRate'] ?? 0 }}%;"
                        role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <small class="text-muted d-block mb-1">Rooms</small>
                <h3 class="mb-0">
                    {{ ($dashboardData['roomStats']['busy'] ?? 0) + ($dashboardData['roomStats']['renew'] ?? 0) }}</h3>
                <small class="text-muted">
                    {{ $dashboardData['roomStats']['available'] ?? 0 }} available,
                    {{ $dashboardData['roomStats']['total'] ?? 0 }} rooms
                </small>
            </div>
        </div>
    </div>
    {{--     <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <small class="text-muted d-block mb-1">Pending Payments</small>
                <h3 class="mb-0">{{ $dashboardData['pendingPayments'] ?? 0 }}</h3>
                <small class="text-muted">{{ $dashboardData['processingPayments'] ?? 0 }} processing</small>
            </div>
        </div>
    </div> --}}
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <small class="text-muted d-block mb-1">Overdue Follow-up</small>
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="mb-0">{{ $dashboardData['overduePayments'] ?? 0 }}</h3>
                    <i class="icon-base bx bx-error-circle text-danger" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Recent Contracts</h5>
                <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-primary">See all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>Student</th>
                            <th>Room</th>
                            <th>Status</th>
                            <th>Start Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                            <tr>
                                <td>{{ $contract->user?->firstname ?? 'N/A' }} {{ $contract->user?->lastname ?? '' }}
                                </td>
                                <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}
                                </td>
                                <td><span class="badge bg-success">{{ $contract->status?->label ?? 'Unknown' }}</span>
                                </td>
                                <td>{{ optional($contract->start_date)->format('d/m/Y') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No contracts found</td>
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
                <h5 class="mb-0">Recent Payments</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary">See all</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>ID</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['recentPayments'] ?? [] as $payment)
                            <tr>
                                <td>#{{ $payment->id }}</td>
                                <td>{{ $payment->contract?->user?->firstname ?? 'N/A' }}
                                    {{ $payment->contract?->user?->lastname ?? '' }}
                                </td>
                                <td>{{ number_format($payment->expected_amount ?? 0, 0, ',', ' ') }} FCFA</td>
                                <td><span
                                        class="badge @if ($payment->status?->code === 'validated') bg-success @elseif($payment->status?->code === 'processing') bg-info @elseif($payment->status?->code === 'cancelled') bg-info bg-danger @elseif($payment->status?->code === 'overdue') bg-danger text-black @else bg-warning @endif">{{ $payment->status?->label ?? 'Unknown' }}</span>
                                </td>
                                <td>
                                    @if ($payment->status->code === 'cancelled' || $payment->status->code === 'validated')
                                        <span class="text-muted">#</span>
                                    @else
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if ($payment->status->code === 'pending' || $payment->status->code === 'overdue')
                                                    <form method="POST"
                                                        action="{{ route('payments.cancel', $payment) }}">
                                                        @csrf
                                                        <button class="dropdown-item text-danger" type="submit">
                                                            <i class="icon-base bx bx-x me-1"></i>Cancel
                                                        </button>
                                                    </form>
                                                @elseif ($payment->status->code === 'processing')
                                                    <form method="POST"
                                                        action="{{ route('payments.validate', $payment) }}">
                                                        @csrf
                                                        <button class="dropdown-item text-info" type="submit">
                                                            <i class="icon-base bx bx-check me-1"></i>Validate
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No payments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
