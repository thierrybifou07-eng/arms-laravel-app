@extends('layouts.app')

@section('content')
    <div class="col-xxl-12" x-data>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex justify-content-start">
                <h5 class="m-1">Payments</h5>
            </div>
            {{--             <div class="d-flex justify-content-end">
                <a href="{{ route('contracts.create') }}" class="btn rounded-pill btn-primary">New Contract</a>
            </div> --}}
        </div>
        <div class="card">
            <div class="row m-3 gap-3">
                <form method="GET" action="{{ route('payments.index') }}" class="d-flex flex-wrap" x-data>
                    <div class="d-md-flex justify-content-between align-items-end dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-length">
                            <label for="payment-status" class="form-label">Status
                                <select name="status" id="payment-status"
                                    class="form-select form-select-sm d-inline-block ms-2" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="validated" {{ request('status') === 'validated' ? 'selected' : '' }}>
                                        Validated</option>
                                    <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue
                                    </option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-end dt-layout-end col-md-auto gap-2 flex-wrap">
                        <div>
                            <label for="payment-search" class="form-label">Search:</label>
                            <input type="search" name="search" id="payment-search" class="form-control form-control-sm"
                                placeholder="Contract, Student..." value="{{ request('search') }}"
                                @input.debounce.500ms="$el.form.submit()">
                        </div>
                    </div>
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
                            <th>Method</th>
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
                                <td>
                                    @if (($payment->status->code === 'processing' || $payment->status->code === 'validated') && $payment->method)
                                        <span class="badge bg-label-info">{{ $payment->method->label }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="" class="">
                                        @php $status = $payment->status->code ?? '' @endphp

                                        @if ($payment->isOverdue())
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            @switch($payment->status->code)
                                                @case('pending')
                                                    <span class="badge bg-label-warning">{{ $payment->status->label }}</span>
                                                @break

                                                @case('validated')
                                                    <span class="badge bg-label-success">{{ $payment->status->label }}</span>
                                                @break

                                                @case('cancelled')
                                                    <span class="badge bg-label-secondary">{{ $payment->status->label }}</span>
                                                @break

                                                @case('processing')
                                                    <span class="badge bg-label-info">{{ $payment->status->label }}</span>
                                                @break

                                                @default
                                                    <span
                                                        class="badge bg-label-dark">{{ $payment->status->label ?? 'Unknown' }}</span>
                                            @endswitch
                                        @endif
                                    </a>
                                </td>

                                <td>
                                    @if ($payment->status->code === 'validated')
                                        <a class="btn btn-sm btn-info" href="{{ route('payments.show.pay', $payment) }}">
                                            <i class="icon-base bx bx-check me-1"></i>Show
                                        </a>
                                    @else
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if ($payment->status->code === 'pending' || $payment->status->code === 'overdue')
                                                    <button type="button" class="dropdown-item text-primary"
                                                        onclick="openModal('pay-modal-{{ $payment->id }}')">
                                                        <i class="icon-base bx bx-money me-1"></i>Pay</button>
                                                    <hr class="dropdown-divider">
                                                    <form method="POST" action="{{ route('payments.cancel', $payment) }}">
                                                        @csrf
                                                        <button class="dropdown-item text-danger" type="submit">
                                                            <i class="icon-base bx bx-x me-1"></i>Cancel
                                                        </button>
                                                    </form>
                                                @elseif ($payment->status->code === 'processing')
                                                    <form method="POST"
                                                        action="{{ route('payments.validate', $payment) }}">
                                                        @csrf
                                                        <button class="dropdown-item text-success" type="submit">
                                                            <i class="icon-base bx bx-check me-1"></i>Validate
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
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
    </div>

    @foreach ($payments as $payment)
        @include('payments.pay-modal', ['payment' => $payment, 'paymentMethods' => $paymentMethods ?? \App\Models\PaymentMethod::all()])
    @endforeach
@endsection
