<!-- Student Dashboard -->
@if (isset($dashboardData['message']))
    <div class="alert alert-info">{{ $dashboardData['message'] }}</div>
@else
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">{{ $dashboardData['totalContracts'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">My Contracts <span
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
                            <p class="text-muted mb-0">My Payments <span
                                    class="badge bg-success ms-2">{{ $dashboardData['PaidPayments'] ?? 0 }}</span></p>
                        </div>
                        <i class="icon-base bx bx-money text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="table-dark">
                                <th>Room</th>
                                <th>Statut</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                                <tr>
                                    <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}
                                    </td>
                                    <td><span
                                            class="badge bg-success">{{ $contract->status?->label ?? 'Unknown' }}</span>
                                    </td>
                                    <td>{{ optional($contract->start_date)->format('d/m/Y') ?? 'N/A' }}</td>
                                    <td>{{ optional($contract->end_date)->format('d/m/Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No contrat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--         <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">{{ $dashboardData['pendingPayments'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Pending Payments</p>
                        </div>
                        <i class="icon-base bx bx-time-five text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <h5 class="mb-0">My payments</h5>
    <div class="row mt-4">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Due Date</th>
                                <th>Expected(FCFA)</th>
                                <th>Paid(FCFA)</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr class="{{ $payment->isOverdue() ? 'table-danger' : '' }}">
                                    <td>#{{ $payment->id }}</td>
                                    <td>{{ $payment->due_date?->format('d/m/Y') }}</td>
                                    <td>{{ number_format($payment->expected_amount, 0, ',', ' ') }}</td>
                                    <td>{{ number_format($payment->paid_amount, 0, ',', ' ') }}</td>
                                    <td>
                                        @if (($payment->status->code === 'processing' || $payment->status->code === 'validated') && $payment->method)
                                            <span class="badge bg-label-info">{{ $payment->method->label }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('payments.show.pay', $payment) }}" class="">
                                            @php $status = $payment->status->code ?? '' @endphp

                                            @if ($payment->isOverdue())
                                                <span class="badge bg-danger">Overdue</span>
                                            @elseif($status === 'pending')
                                                <span class="badge bg-label-warning">Pending</span>
                                            @elseif($status === 'processing')
                                                <span class="badge bg-label-info">Processing</span>
                                            @elseif($status === 'validated')
                                                <span class="badge bg-label-success">Validated</span>
                                            @elseif($status === 'cancelled')
                                                <span class="badge bg-label-danger">Cancelled</span>
                                            @endif
                                        </a>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-row gap-1 text-center">
                                            {{-- PAY --}}
                                            @if ($payment->status->code === 'pending' || $payment->status->code === 'overdue')
                                                <a href="{{ route('payments.pay.form', $payment) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Pay
                                                </a>
                                            @else
                                                #
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
