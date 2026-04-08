@extends('layouts.app')
@section('content')
    <h5 class="mb-3">Payments History</h5>

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
                <hr>
                <!-- Pagination -->
                <div class="row mx-3 justify-content-between mt-3">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $payment_histories->firstItem() ?? 0 }}
                            to {{ $payment_histories->lastItem() ?? 0 }} of {{ $payment_histories->total() }} Payment Histories</div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li class="dt-paging-button page-item {{ $payment_histories->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $payment_histories->previousPageUrl() }}"
                                            {{ $payment_histories->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($payment_histories->getUrlRange(1, $payment_histories->lastPage()) as $page => $url)
                                        @if ($page == $payment_histories->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif (
                                            $page == 1 ||
                                                $page == $payment_histories->lastPage() ||
                                                ($page >= $payment_histories->currentPage() - 2 && $page <= $payment_histories->currentPage() + 2))
                                            <li class="dt-paging-button page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $payment_histories->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li class="dt-paging-button page-item {{ $payment_histories->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $payment_histories->nextPageUrl() }}"
                                            {{ !$payment_histories->hasMorePages() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
        @else
            <div class="text-center py-5">
                <p>No payment history found.</p>
            </div>
        @endif
    </div>
@endsection
