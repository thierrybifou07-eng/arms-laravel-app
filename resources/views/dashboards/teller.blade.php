<!-- Teller Dashboard -->
<div class="card mb-4">
    <div class="d-flex align-items-start row">
        <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">Welcome {{ Auth::user()->firstname }}
                    {{ Auth::user()->lastname }}! 🎉
                </h5>
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
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalPayments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Payments <span
                                class="badge bg-success ms-2">{{ $dashboardData['validatedPayments'] ?? 0 }}</span></p>
                    </div>
                    <i class="icon-base bx bx-money text-success" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['pendingPayments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Pending</p>
                    </div>
                    <i class="icon-base bx bx-time-five text-warning" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['processingPayments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Processing</p>
                    </div>
                    <i class="icon-base bx bx-hourglass text-info" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12 mb-4">
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
                                        class="badge @if ($payment->status?->code === 'validated') bg-success @elseif($payment->status?->code === 'processing') bg-info @else bg-warning @endif">{{ $payment->status?->label ?? 'Unknown' }}</span>
                                </td>
                                <td>
                                    @if ($payment->status->code === 'pending' || $payment->status->code === 'overdue')
                                        <form method="POST" action="{{ route('payments.cancel', $payment) }}">
                                            @csrf
                                            <button class="dropdown-item text-danger" type="submit">
                                                <i class="icon-base bx bx-x me-1"></i>Cancel
                                            </button>
                                        </form>
                                    @elseif ($payment->status->code === 'processing')
                                        <form method="POST" action="{{ route('payments.validate', $payment) }}">
                                            @csrf
                                            <button class="btn btn-xs btn-info" type="submit">
                                                <i class="icon-base bx bx-check me-1"></i>Validate
                                            </button>
                                        </form>
                                    @else
                                        #
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No payments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>