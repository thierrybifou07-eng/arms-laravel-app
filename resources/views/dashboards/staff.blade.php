<!-- Staff Dashboard -->
<div class="card mb-4">
    <div class="d-flex align-items-start row">
        <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">Bienvenue {{ Auth::user()->firstname }}
                    {{ Auth::user()->lastname }}! 🎉</h5>
                <p class="mb-3">Vous êtes connecté en tant que
                    <strong>{{ Auth::user()->roles->first()->label }}</strong></p>
                <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                    <i class="icon-base bx bx-user me-1"></i> Vue Profil
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
                                <td>{{ $contract->user?->firstname ?? 'N/A' }} {{ $contract->user?->lastname ?? '' }}</td>
                                <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}
                                </td>
                                <td><span class="badge bg-success">{{ $contract->status?->label ?? 'Unknown' }}</span>
                                </td>
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
