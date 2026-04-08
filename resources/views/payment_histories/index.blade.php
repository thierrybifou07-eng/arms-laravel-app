@extends('layouts.app')
@section('content')
    <h5 class="mb-3">Payment History</h5>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card my-5">
        <div class="card-header">
            <div class="row mx-1 my-0 justify-content-between align-items-end">
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <form method="GET" action="{{ route('payment_histories.index') }}" x-data>

                            <label for="history-search" class="form-label">Search:</label>
                            <input type="search" name="search" id="history-search" class="form-control form-control-sm"
                                placeholder="Payment ID, Student..." value="{{ request('search') }}"
                                @input.debounce.750ms="$el.form.submit()">
                        </form>
                    </div>
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-1">
                        @can('export', App\Models\PaymentHistory::class)
                            <form action="{{ route('payment_histories.export') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bx bx-download me-1"></i> Export
                                </button>
                            </form>
                        @endcan
                    </div>
            </div>
        </div>
        @if ($payment_histories->count() > 0)
            <div class="table-responsive table-hover text-nowrap">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Payment ID</th>
                            <th>Student</th>
                            <th>Amount (FCFA)</th>
                            <th>Old Balance (FCFA)</th>
                            <th>New Balance (FCFA)</th>
                            <th>Date</th>
                            <th>Recorded By</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($payment_histories as $history)
                            <tr>
                                <td><span class="fw-medium">#{{ $history->payment_id }}</span></td>
                                <td>{{ $history->payment->contract->user->firstname ?? 'N/A' }}
                                    {{ $history->payment->contract->user->lastname ?? '' }}</td>
                                <td>{{ number_format($history->amount, 2, ',', ' ') }} FCFA</td>
                                <td>{{ number_format($history->old_balance, 2, ',', ' ') }} FCFA</td>
                                <td>{{ number_format($history->new_balance, 2, ',', ' ') }} FCFA</td>
                                <td><span
                                        class="badge bg-label-info">{{ $history->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td>{{ $history->recordedBy->firstname ?? 'N/A' }}
                                    {{ $history->recordedBy->lastname ?? '' }}</td>
                                <td>
                                    @can('view', $history)
                                        <a href="{{ route('payment_histories.show', $history) }}" class="btn btn-sm btn-info">
                                            <i class="bx bx-show-alt me-1"></i>View
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
@endsection
