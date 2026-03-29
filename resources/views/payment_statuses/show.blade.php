@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        <div class="card my-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $payment_status->name }}</h5>
                <div>
                    @can('update', $payment_status)
                    <a href="{{ route('payment_statuses.edit', $payment_status) }}" class="btn btn-warning btn-sm me-2">
                        <i class="icon-base bx bx-edit me-1"></i> Éditer
                    </a>
                    @endcan
                    @can('delete', $payment_status)
                    <form action="{{ route('payment_statuses.destroy', $payment_status) }}" method="POST" class="d-inline">
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
                            <td class="fw-medium">Code:</td>
                            <td><span class="badge bg-light text-dark">{{ $payment_status->code }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="demo-inline-spacing">
            <a href="{{ route('payment_statuses.index') }}" class="btn btn-secondary">
                <i class="icon-base bx bx-arrow-back me-1"></i> Retour à la Liste
            </a>
        </div>
    </div>
@endsection
