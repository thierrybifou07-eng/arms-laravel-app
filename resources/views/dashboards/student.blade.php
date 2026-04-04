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
                            <p class="text-muted mb-0">Mes Contrats <span class="badge bg-success ms-2">{{ $dashboardData['activeContracts'] ?? 0 }}</span></p>
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
                            <p class="text-muted mb-0">Mes Paiements <span class="badge bg-success ms-2">{{ $dashboardData['paidPayments'] ?? 0 }}</span></p>
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
                            <p class="text-muted mb-0">En Attente</p>
                        </div>
                        <i class="icon-base bx bx-time-five text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Mes Contrats</h5>
                    <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="table-dark">
                                <th>Chambre</th>
                                <th>Statut</th>
                                <th>Début</th>
                                <th>Fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                                <tr>
                                    <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}</td>
                                    <td><span class="badge bg-success">{{ $contract->status?->label ?? 'Unknown' }}</span></td>
                                    <td>{{ optional($contract->start_date)->format('d/m/Y') ?? 'N/A' }}</td>
                                    <td>{{ optional($contract->end_date)->format('d/m/Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun contrat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
