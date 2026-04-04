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
                <h5 class="mb-0">Méthodes de Paiement</h5>
                @can('create', App\Models\PaymentMethod::class)
                <a href="{{ route('payment_methods.create') }}" class="btn btn-primary btn-sm">
                    <i class="icon-base bx bx-plus me-1"></i> Ajouter
                </a>
                @endcan
            </div>
            @if ($payment_methods->count() > 0)
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
                            @foreach ($payment_methods as $method)
                                <tr>
                                    <td><span class="fw-medium">{{ $method->name }}</span></td>
                                    <td><span class="badge bg-light text-dark">{{ $method->code }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('view', $method)
                                                <a class="dropdown-item" href="{{ route('payment_methods.show', $method) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>Voir</a>
                                                @endcan
                                                @can('update', $method)
                                                <a class="dropdown-item" href="{{ route('payment_methods.edit', $method) }}">
                                                    <i class="icon-base bx bx-edit me-1"></i>Éditer</a>
                                                @endcan
                                                @can('delete', $method)
                                                <hr class="dropdown-divider">
                                                <form method="POST" action="{{ route('payment_methods.destroy', $method) }}" class="d-inline">
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
                    <a class="btn rounded-pill btn-primary" href="{{ route('payment_methods.create') }}">
                        Aucune méthode - Créer une nouvelle</a>
                </div>
            @endif
        </div>
        @if ($payment_methods->count() > 0)
            <div class="demo-inline-spacing mx-5">
                {{ $payment_methods->links() }}
            </div>
        @endif
    </div>
@endsection
