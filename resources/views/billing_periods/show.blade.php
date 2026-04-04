@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card my-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $billing_period->name }}</h5>
                <div>
                    @can('update', $billing_period)
                    <a href="{{ route('billing_periods.edit', $billing_period) }}" class="btn btn-warning btn-sm me-2">
                        <i class="icon-base bx bx-edit me-1"></i> Éditer
                    </a>
                    @endcan
                    @can('delete', $billing_period)
                    <form action="{{ route('billing_periods.destroy', $billing_period) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Êtes-vous sûr?')">
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
                            <td class="fw-medium">Début:</td>
                            <td>{{ $billing_period->start_date->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Fin:</td>
                            <td>{{ $billing_period->end_date->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Contrat:</td>
                            <td>
                                <a href="{{ route('contracts.show', $billing_period->contract_id) }}">
                                    Contrat #{{ $billing_period->contract_id }}
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="demo-inline-spacing">
            <a href="{{ route('billing_periods.index') }}" class="btn btn-secondary">
                <i class="icon-base bx bx-arrow-back me-1"></i> Retour à la Liste
            </a>
        </div>
    </div>
@endsection
