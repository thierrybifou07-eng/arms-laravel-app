@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        <div class="card my-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Entrée d'Historique #{{ $payment_history->id }}</h5>
                <a href="{{ route('payment_histories.index') }}" class="btn btn-secondary btn-sm">
                    <i class="icon-base bx bx-arrow-back me-1"></i> Retour
                </a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td class="fw-medium">Paiement ID:</td>
                            <td>#{{ $payment_history->payment_id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Montant (DZD):</td>
                            <td><span class="badge bg-success">{{ number_format($payment_history->amount, 2, ',', ' ') }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Ancien Solde:</td>
                            <td>{{ number_format($payment_history->old_balance, 2, ',', ' ') }} DZD</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Nouveau Solde:</td>
                            <td>{{ number_format($payment_history->new_balance, 2, ',', ' ') }} DZD</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Notes:</td>
                            <td>
                                @if ($payment_history->notes)
                                    {{ $payment_history->notes }}
                                @else
                                    <em class="text-muted">Aucune note</em>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Créé le:</td>
                            <td><span class="badge bg-label-info">{{ $payment_history->created_at->format('d/m/Y H:i:s') }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="demo-inline-spacing">
            <a href="{{ route('payment_histories.index') }}" class="btn btn-secondary">
                <i class="icon-base bx bx-arrow-back me-1"></i> Retour à la Liste
            </a>
        </div>
    </div>
@endsection
