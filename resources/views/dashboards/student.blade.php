<!-- Student Dashboard -->
@if (isset($dashboardData['message']))
    <div class="alert alert-info">{{ $dashboardData['message'] }}</div>
@else
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
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
        <div class="col-lg-4 col-md-6 mb-4">
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
        <div class="col-lg-4 col-md-6 mb-4">
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
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12 mb-4">
            <h5 class="mb-2">My Contracts</h5>
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
    </div>
@endif
