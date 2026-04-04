@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        <div class="card my-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $event_payment_type->name }}</h5>
                <div>
                    @can('update', $event_payment_type)
                    <a href="{{ route('event_payment_types.edit', $event_payment_type) }}" class="btn btn-warning btn-sm me-2">
                        <i class="icon-base bx bx-edit me-1"></i> Éditer
                    </a>
                    @endcan
                    @can('delete', $event_payment_type)
                    <form action="{{ route('event_payment_types.destroy', $event_payment_type) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?')">
                            <i class="icon-base bx bx-trash me-1"></i> Supprimer
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td class="fw-medium">Montant (DZD):</td>
                            <td><span class="badge bg-light text-dark">{{ number_format($event_payment_type->amount, 2, ',', ' ') }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Code:</td>
                            <td><span class="badge bg-light text-dark">{{ $event_payment_type->code }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="demo-inline-spacing">
            <a href="{{ route('event_payment_types.index') }}" class="btn btn-secondary">
                <i class="icon-base bx bx-arrow-back me-1"></i> Retour à la Liste
            </a>
        </div>
    </div>
@endsection
