@extends('layouts.app')
@section('content')
    <div class="col-xxl-12" x-data>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card my-5">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Types de Paiement d'Événement</h5>
                @can('create', App\Models\EventPaymentType::class)
                <button type="button" class="btn btn-primary btn-sm" onclick="openModal('create-event-payment-type')">
                    <i class="icon-base bx bx-plus me-1"></i> Ajouter
                </button>
                @endcan
            </div>
            @if ($eventPaymentTypes->count() > 0)
                <div class="table-responsive table-hover text-nowrap">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Nom</th>
                                <th>Montant (DZD)</th>
                                <th>Code</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($eventPaymentTypes as $type)
                                <tr>
                                    <td><span class="fw-medium">{{ $type->name }}</span></td>
                                    <td>{{ number_format($type->amount, 2, ',', ' ') }} DZD</td>
                                    <td><span class="badge bg-light text-dark">{{ $type->code }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('view', $type)
                                                <a class="dropdown-item" href="{{ route('event_payment_types.show', $type) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>Voir</a>
                                                @endcan
                                                @can('update', $type)
                                                <button type="button" class="dropdown-item" onclick="openModal('edit-event-payment-type-{{ $type->id }}')">
                                                    <i class="icon-base bx bx-edit me-1"></i>Éditer</button>
                                                @endcan
                                                @can('delete', $type)
                                                <hr class="dropdown-divider">
                                                <form method="POST" action="{{ route('event_payment_types.destroy', $type) }}" class="d-inline">
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
                    <a class="btn rounded-pill btn-primary" href="{{ route('event_payment_types.create') }}">
                        Aucun type - Créer un nouveau</a>
                </div>
            @endif
        </div>
        @if ($eventPaymentTypes->count() > 0)
            <div class="demo-inline-spacing mx-5">
                {{ $eventPaymentTypes->links() }}
            </div>
        @endif
    </div>

    {{-- Create Modal --}}
    @include('event_payment_types.form-modal')

    {{-- Edit Modals --}}
    @foreach ($eventPaymentTypes as $type)
        @include('event_payment_types.form-modal', ['eventPaymentType' => $type])
    @endforeach

@endsection
