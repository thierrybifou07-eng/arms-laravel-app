<!-- Teller Dashboard -->
<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalPayments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Paiements <span class="badge bg-success ms-2">{{ $dashboardData['validatedPayments'] ?? 0 }}</span></p>
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
                        <p class="text-muted mb-0">En attente</p>
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
                        <p class="text-muted mb-0">En traitement</p>
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
                <h5 class="mb-0">Paiements Récents</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>ID</th>
                            <th>Étudiant</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['recentPayments'] ?? [] as $payment)
                            <tr>
                                <td>#{{ $payment->id }}</td>
                                <td>{{ $payment->contract?->student?->surname ?? 'N/A' }}</td>
                                <td>{{ number_format($payment->expected_amount ?? 0, 0, ',', ' ') }} DZD</td>
                                <td><span class="badge @if ($payment->status?->code === 'validated') bg-success @elseif($payment->status?->code === 'processing') bg-info @else bg-warning @endif">{{ $payment->status?->label ?? 'Unknown' }}</span></td>
                                <td><a href="{{ route('payments.show.pay', $payment) }}" class="btn btn-xs btn-info"><i class="icon-base bx bx-edit"></i></a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Aucun paiement</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
