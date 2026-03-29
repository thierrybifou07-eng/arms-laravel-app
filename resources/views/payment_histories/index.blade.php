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
                <h5 class="mb-0">Historique des Paiements</h5>
                <div>
                    @can('export', App\Models\PaymentHistory::class)
                    <form action="{{ route('payment_histories.export') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="icon-base bx bx-download me-1"></i> Exporter
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            @if ($payment_histories->count() > 0)
                <div class="table-responsive table-hover text-nowrap">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Paiement ID</th>
                                <th>Montant (DZD)</th>
                                <th>Ancien Solde</th>
                                <th>Nouveau Solde</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($payment_histories as $history)
                                <tr>
                                    <td><span class="fw-medium">#{{ $history->payment_id }}</span></td>
                                    <td>{{ number_format($history->amount, 2, ',', ' ') }} DZD</td>
                                    <td>{{ number_format($history->old_balance, 2, ',', ' ') }} DZD</td>
                                    <td>{{ number_format($history->new_balance, 2, ',', ' ') }} DZD</td>
                                    <td><span class="badge bg-label-info">{{ $history->created_at->format('d/m/Y H:i') }}</span></td>
                                    <td>
                                        @can('view', $history)
                                        <a href="{{ route('payment_histories.show', $history) }}" class="btn btn-sm btn-info">
                                            <i class="icon-base bx bx-show-alt me-1"></i>Voir
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <p>Aucun historique de paiement trouvé.</p>
                </div>
            @endif
        </div>
        @if ($payment_histories->count() > 0)
            <div class="demo-inline-spacing mx-5">
                {{ $payment_histories->links() }}
            </div>
        @endif
    </div>
@endsection
