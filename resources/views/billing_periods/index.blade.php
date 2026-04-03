@extends('layouts.app')
@section('content')
    <div class="col-xxl-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card my-5">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Périodes de Facturation</h5>
                @can('create', App\Models\BillingPeriod::class)
                <a href="{{ route('billing_periods.create') }}" class="btn btn-primary btn-sm">
                    <i class="icon-base bx bx-plus me-1"></i> Ajouter Période
                </a>
                @endcan
            </div>
            @if ($billingPeriods->count() > 0)
                <div class="table-responsive table-hover text-nowrap">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom</th>
                                <th>Contrat</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($billingPeriods as $period)
                                <tr>
                                    <td><span class="fw-medium">{{ $period->name }}</span></td>
                                    <td>{{ $period->contract_id }}</td>
                                    <td>{{ $period->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $period->end_date->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('view', $period)
                                                <a class="dropdown-item" href="{{ route('billing_periods.show', $period) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>Voir</a>
                                                @endcan
                                                @can('update', $period)
                                                <a class="dropdown-item" href="{{ route('billing_periods.edit', $period) }}">
                                                    <i class="icon-base bx bx-edit me-1"></i>Éditer</a>
                                                @endcan
                                                @can('delete', $period)
                                                <hr class="dropdown-divider">
                                                <form method="POST" action="{{ route('billing_periods.destroy', $period) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger" type="submit" onclick="return confirm('Êtes-vous sûr?')">
                                                        <i class="icon-base bx bx-trash me-1"></i>Supprimer
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <a class="btn rounded-pill btn-primary" href="{{ route('billing_periods.create') }}">
                        Aucune période trouvée - Créer une nouvelle</a>
                </div>
            @endif
        </div>
        @if ($billingPeriods->count() > 0)
            <div class="demo-inline-spacing mx-5">
                {{ $billingPeriods->links() }}
            </div>
        @endif
    </div>
@endsection
