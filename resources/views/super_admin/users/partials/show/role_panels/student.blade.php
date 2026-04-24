@include('super_admin.users.partials.show.stats_grid', ['stats' => $roleInsights['stats'] ?? []])

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bx bx-home-alt me-2"></i>Current Accommodation
                </h6>
            </div>
            <div class="card-body">
                @if (!empty($roleInsights['active_contract']))
                    <div class="mb-3">
                        <small class="text-muted d-block">Residence</small>
                        <h5 class="mb-0">
                            {{ $roleInsights['active_contract']->room?->floor?->building?->residence?->name ?? 'N/A' }}
                        </h5>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Room</small>
                        <span>
                            {{ $roleInsights['active_contract']->room?->floor?->building?->name ?? 'N/A' }}
                            / F{{ $roleInsights['active_contract']->room?->floor?->number ?? 'N/A' }}
                            / R{{ $roleInsights['active_contract']->room?->number ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Contract period</small>
                        <span>
                            {{ $roleInsights['active_contract']->start_date?->format('M d, Y') ?? 'N/A' }} -
                            {{ $roleInsights['active_contract']->end_date?->format('M d, Y') ?? 'N/A' }}
                        </span>
                    </div>
                    <a href="{{ route('contracts.show', $roleInsights['active_contract']) }}"
                        class="btn btn-sm btn-outline-primary">
                        Open contract
                    </a>
                @else
                    <div class="alert alert-light mb-0">
                        <i class="bx bx-info-circle me-2"></i>No active accommodation contract is assigned right now.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bx bx-calendar-event me-2"></i>Next Payment
                </h6>
            </div>
            <div class="card-body">
                @if (!empty($roleInsights['next_payment']))
                    <div class="mb-3">
                        <small class="text-muted d-block">Due date</small>
                        <h5 class="mb-0">{{ $roleInsights['next_payment']->due_date?->format('M d, Y') ?? 'N/A' }}</h5>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Expected amount</small>
                        <span>{{ number_format($roleInsights['next_payment']->expected_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Remaining balance</small>
                        <span>
                            {{ number_format(max(0, ($roleInsights['next_payment']->expected_amount ?? 0) - ($roleInsights['next_payment']->paid_amount ?? 0)), 0, ',', ' ') }}
                            FCFA
                        </span>
                    </div>
                    <a href="{{ route('payments.show.pay', $roleInsights['next_payment']) }}"
                        class="btn btn-sm btn-outline-primary">
                        Open payment
                    </a>
                @else
                    <div class="alert alert-light mb-0">
                        <i class="bx bx-info-circle me-2"></i>No open payment is scheduled for this student.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="bx bx-credit-card-front me-2"></i>Recent Payments
        </h6>
    </div>
    <div class="card-body">
        @if (!empty($roleInsights['recent_payments']) && $roleInsights['recent_payments']->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Payment</th>
                            <th>Residence</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roleInsights['recent_payments'] as $payment)
                            <tr>
                                <td>
                                    <a href="{{ route('payments.show.pay', $payment) }}" class="text-primary">
                                        #{{ $payment->id }}
                                    </a>
                                </td>
                                <td>{{ $payment->contract?->room?->floor?->building?->residence?->name ?? 'N/A' }}</td>
                                <td>{{ number_format($payment->expected_amount ?? 0, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    @if ($payment->isOverdue())
                                        <span class="badge bg-danger">Overdue</span>
                                    @elseif (($payment->status?->code ?? '') === 'validated')
                                        <span class="badge bg-success">{{ $payment->status?->label }}</span>
                                    @elseif (($payment->status?->code ?? '') === 'processing')
                                        <span class="badge bg-info">{{ $payment->status?->label }}</span>
                                    @elseif (($payment->status?->code ?? '') === 'pending')
                                        <span class="badge bg-warning">{{ $payment->status?->label }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $payment->status?->label ?? 'Unknown' }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-light mb-0">
                <i class="bx bx-info-circle me-2"></i>This student has no payment history yet.
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="bx bx-file-blank me-2"></i>Contracts
        </h6>
    </div>
    <div class="card-body">
        @if ($user->contracts->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Contract ID</th>
                            <th>Residence / Room</th>
                            <th>Status</th>
                            <th>Period</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->contracts->take(5) as $contract)
                            <tr>
                                <td>
                                    <a href="{{ route('contracts.show', $contract) }}" class="text-primary">
                                        #{{ $contract->id }}
                                    </a>
                                </td>
                                <td>
                                    {{ $contract->room?->floor?->building?->residence?->name ?? 'N/A' }}
                                    / F{{ $contract->room?->floor?->number ?? 'N/A' }}
                                    / R{{ $contract->room?->number ?? 'N/A' }}
                                </td>
                                <td>
                                    @php $statusCode = $contract->status?->code; @endphp
                                    @if ($statusCode === 'active')
                                        <span class="badge bg-success">{{ $contract->status->label }}</span>
                                    @elseif ($statusCode === 'pending')
                                        <span class="badge bg-warning">{{ $contract->status->label }}</span>
                                    @elseif ($statusCode === 'overdue')
                                        <span class="badge bg-danger">{{ $contract->status->label }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $contract->status?->label ?? 'Unknown' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $contract->start_date?->format('M d, Y') ?? 'N/A' }} -
                                        {{ $contract->end_date?->format('M d, Y') ?? 'N/A' }}
                                    </small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($user->contracts->count() > 5)
                <small class="text-muted">
                    <em>Showing 5 of {{ $user->contracts->count() }} contracts</em>
                </small>
            @endif
        @else
            <div class="alert alert-light mb-0">
                <i class="bx bx-info-circle me-2"></i>This student has no contract yet.
            </div>
        @endif
    </div>
</div>
