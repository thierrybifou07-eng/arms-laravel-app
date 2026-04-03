<!-- Staff Dashboard -->
<div class="row">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalStudents'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Étudiants</p>
                    </div>
                    <i class="icon-base bx bx-user-circle text-primary" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{ $dashboardData['totalContracts'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Contrats</p>
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
                        <h3 class="mb-0">{{ $dashboardData['totalBillingPeriods'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Périodes</p>
                    </div>
                    <i class="icon-base bx bx-calendar text-warning" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Contrats Récents</h5>
                <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>Étudiant</th>
                            <th>Chambre</th>
                            <th>Statut</th>
                            <th>Date Début</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                            <tr>
                                <td>{{ $contract->student?->surname ?? 'N/A' }}</td>
                                <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}</td>
                                <td><span class="badge bg-success">{{ $contract->status?->label ?? 'Unknown' }}</span></td>
                                <td>{{ optional($contract->start_date)->format('d/m/Y') ?? 'N/A' }}</td>
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
