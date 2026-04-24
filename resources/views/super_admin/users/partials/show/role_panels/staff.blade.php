@include('super_admin.users.partials.show.stats_grid', ['stats' => $roleInsights['stats'] ?? []])

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bx bx-current-location me-2"></i>Assigned Residences
                </h6>
            </div>
            <div class="card-body">
                @if (!empty($roleInsights['managed_residences']) && $roleInsights['managed_residences']->isNotEmpty())
                    @foreach ($roleInsights['managed_residences'] as $residence)
                        <div class="border rounded p-3 {{ $loop->last ? '' : 'mb-3' }}">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <h6 class="mb-1">{{ $residence->name }}</h6>
                                    <p class="text-muted mb-2">{{ $residence->city ?? 'City not defined' }}</p>
                                </div>
                                <span class="badge bg-label-secondary">{{ $residence->status?->label ?? 'No status' }}</span>
                            </div>
                            <a href="{{ route('residences.show', $residence) }}" class="btn btn-sm btn-outline-primary">
                                Open residence
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-light mb-0">
                        <i class="bx bx-info-circle me-2"></i>This staff account has no residence assignment yet.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-7 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bx bx-credit-card me-2"></i>Recent Payment Follow-up
                </h6>
            </div>
            <div class="card-body">
                @if (!empty($roleInsights['recent_payments']) && $roleInsights['recent_payments']->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Payment</th>
                                    <th>Student</th>
                                    <th>Expected</th>
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
                                        <td>{{ $payment->contract?->user?->firstname ?? 'N/A' }}
                                            {{ $payment->contract?->user?->lastname ?? '' }}</td>
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
                        <i class="bx bx-info-circle me-2"></i>No payment follow-up data is available for this staff member.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
