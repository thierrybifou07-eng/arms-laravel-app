@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Payments</h5>

            <form method="GET">
                <select name="status" onchange="this.form.submit()" class="form-select">
                    <option value="">All</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="validated" {{ request('status') == 'validated' ? 'selected' : '' }}>Validated</option>
                </select>
            </form>

        </div>

        <div class="table-responsive text-nowrap table-hover">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Contract</th>
                        <th>Student</th>
                        <th>Due Date</th>
                        <th>Expected(FCFA)</th>
                        <th>Paid(FCFA)</th>
                        {{-- <th>Tip amount(FCFA)</th> --}}
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="{{ $payment->isOverdue() ? 'table-danger' : '' }}">
                            <td>#{{ $payment->contract->id }}</td>
                            <td>{{ $payment->contract->user->firstname }} {{ $payment->contract->user->lastname }}</td>

                            <td>{{ $payment->due_date?->format('d/m/Y') }}</td>

                            <td>{{ number_format($payment->expected_amount, 0, ',', ' ') }}</td>
                            <td>{{ number_format($payment->paid_amount, 0, ',', ' ') }}</td>
                            {{--                             <td>{{ number_format($payment->tip_amount, 0, ',', ' ') }}</td>
 --}}
                            <td>
                                <a href="{{ route('payments.show.pay', $payment) }}" class="">
                                    @php $status = $payment->status->code ?? '' @endphp

                                    @if ($payment->isOverdue())
                                        <span class="badge bg-danger">Overdue</span>
                                    @elseif($status === 'pending')
                                        <span class="badge bg-label-warning">Pending</span>
                                    @elseif($status === 'processing')
                                        <span class="badge bg-label-info">Processing</span>
                                    @elseif($status === 'validated')
                                        <span class="badge bg-label-success">Validated</span>
                                    @elseif($status === 'cancelled')
                                        <span class="badge bg-label-danger">Cancelled</span>
                                    @endif
                                </a>
                            </td>

                            <td>
                                <div class="d-flex flex-row gap-1">
                                    {{-- PAY --}}
                                    @if (
                                        $payment->status->code === 'pending' ||
                                            $payment->status->code === 'cancelled' ||
                                            $payment->status->code === 'overdue')
                                        <a href="{{ route('payments.pay.form', $payment) }}"
                                            class="btn btn-sm btn-primary">
                                            Pay
                                        </a>
                                    @endif
                                    {{-- VALIDATE --}}
                                    @if ($payment->status->code === 'processing')
                                        <form method="POST" action="{{ route('payments.validate', $payment) }}"
                                            class="mt-3">
                                            @csrf
                                            <button class="btn btn-success">Validate</button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="row mx-3 mt-3 justify-content-between">
            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                <div class="dt-info" aria-live="polite" role="status">Showing {{ $payments->firstItem() ?? 0 }}
                    to {{ $payments->lastItem() ?? 0 }} of {{ $payments->total() }} payments</div>
            </div>
            <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                <div class="dt-paging">
                    <nav aria-label="pagination">
                        <ul class="pagination">
                            {{-- Previous Button --}}
                            <li class="dt-paging-button page-item {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link previous" href="{{ $payments->previousPageUrl() }}"
                                    {{ $payments->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                    <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                </a>
                            </li>

                            {{-- Pagination Elements --}}
                            @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                                @if ($page == $payments->currentPage())
                                    <li class="dt-paging-button page-item active">
                                        <span class="page-link" aria-current="page">{{ $page }}</span>
                                    </li>
                                @elseif (
                                    $page == 1 ||
                                        $page == $payments->lastPage() ||
                                        ($page >= $payments->currentPage() - 2 && $page <= $payments->currentPage() + 2))
                                    <li class="dt-paging-button page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @elseif ($page == 2 || $page == $payments->lastPage() - 1)
                                    <li class="dt-paging-button page-item disabled">
                                        <span class="page-link ellipsis">…</span>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Button --}}
                            <li class="dt-paging-button page-item {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link next" href="{{ $payments->nextPageUrl() }}"
                                    {{ !$payments->hasMorePages() ? 'aria-disabled=true' : '' }}>
                                    <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
