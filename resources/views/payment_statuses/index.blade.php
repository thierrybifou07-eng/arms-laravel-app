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
                <h5 class="mb-0">Statuts de Paiement</h5>
                @can('create', App\Models\PaymentStatus::class)
                <a href="{{ route('payment_statuses.create') }}" class="btn btn-primary btn-sm">
                    <i class="icon-base bx bx-plus me-1"></i> Ajouter
                </a>
                @endcan
            </div>
            @if ($payment_statuses->count() > 0)
                <div class="table-responsive table-hover text-nowrap">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom</th>
                                <th>Code</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($payment_statuses as $status)
                                <tr>
                                    <td><span class="fw-medium">{{ $status->name }}</span></td>
                                    <td><span class="badge bg-light text-dark">{{ $status->code }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('view', $status)
                                                <a class="dropdown-item" href="{{ route('payment_statuses.show', $status) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>Voir</a>
                                                @endcan
                                                @can('update', $status)
                                                <a class="dropdown-item" href="{{ route('payment_statuses.edit', $status) }}">
                                                    <i class="icon-base bx bx-edit me-1"></i>Éditer</a>
                                                @endcan
                                                @can('delete', $status)
                                                <hr class="dropdown-divider">
                                                <form method="POST" action="{{ route('payment_statuses.destroy', $status) }}" class="d-inline">
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
                    <a class="btn rounded-pill btn-primary" href="{{ route('payment_statuses.create') }}">
                        Aucun statut - Créer un nouveau</a>
                </div>
            @endif
        </div>
        @if ($payment_statuses->count() > 0)
            <div class="demo-inline-spacing mx-5">
                {{ $payment_statuses->links() }}
            </div>
        @endif
    </div>
@endsection
