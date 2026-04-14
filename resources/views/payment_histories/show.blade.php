@extends('layouts.app')

@section('content')
    <div class="col-xxl-6">
        <div class="card my-4">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td class="fw-medium">Payment ID:</td>
                            <td>#{{ $paymentHistory->payment_id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Amount (FCFA):</td>
                            <td><span class="badge bg-success">{{ number_format($paymentHistory->amount, 2, ',', ' ') }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Old Balance:</td>
                            <td>{{ number_format($paymentHistory->old_balance, 2, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">New Balance:</td>
                            <td>{{ number_format($paymentHistory->new_balance, 2, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Notes:</td>
                            <td>
                                @if ($paymentHistory->notes)
                                    {{ $paymentHistory->notes }}
                                @else
                                    <em class="text-muted">No note</em>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Created at:</td>
                            <td><span class="badge bg-label-info">{{ $paymentHistory->created_at->format('d/m/Y H:i:s') }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="demo-inline-spacing">
            <a href="{{ route('payment_histories.index') }}" class="btn btn-secondary">
                <i class="icon-base bx bx-arrow-back me-1"></i> Return to List
            </a>
        </div>
    </div>
@endsection
