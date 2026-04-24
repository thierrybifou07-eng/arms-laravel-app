@if (isset($dashboardData['message']))
    <div class="alert alert-info">{{ $dashboardData['message'] }}</div>
@else
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">{{ $dashboardData['totalContracts'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">My Contracts <span
                                    class="badge bg-success ms-2">{{ $dashboardData['activeContracts'] ?? 0 }}</span></p>
                        </div>
                        <i class="icon-base bx bx-receipt text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h3 class="mb-0">{{ $dashboardData['totalPayments'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">My Payments <span
                                    class="badge bg-success ms-2">{{ $dashboardData['paidPayments'] ?? 0 }}</span></p>
                        </div>
                        <i class="icon-base bx bx-money text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
                <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">Current Residence</small>
                    <h5 class="mb-1">{{ $dashboardData['currentResidence']?->name ?? 'Not assigned' }}</h5>
                    <small class="text-muted">{{ $dashboardData['currentResidence']?->city ?? '' }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">Outstanding Balance</small>
                    <h3 class="mb-0">{{ number_format($dashboardData['outstandingBalance'] ?? 0, 0, ',', ' ') }}</h3>
                    <small class="text-muted">FCFA still open</small>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">Next Payment</small>
                    @if (!empty($dashboardData['nextPayment']))
                        <h5 class="mb-1">
                            {{ number_format($dashboardData['nextPayment']->expected_amount, 0, ',', ' ') }} FCFA</h5>
                        <small class="text-muted">Due
                            {{ $dashboardData['nextPayment']->due_date?->format('d/m/Y') }}</small>
                    @else
                        <h5 class="mb-1">No open payment on this page</h5>
                        <small class="text-muted">All visible payments are settled or closed, try the next</small>
                    @endif
                </div>
            </div>
        </div>        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="table-dark">
                                <th>Room</th>
                                <th>Statut</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dashboardData['recentContracts'] ?? [] as $contract)
                                <tr>
                                    <td>{{ $contract->room?->floor?->building?->name ?? 'N/A' }}/F{{ $contract->room?->floor?->number ?? 'N/A' }}/R{{ $contract->room?->number ?? 'N/A' }}
                                    </td>
                                    <td><span
                                            class="badge bg-success">{{ $contract->status?->label ?? 'Unknown' }}</span>
                                    </td>
                                    <td>{{ optional($contract->start_date)->format('d/m/Y') ?? 'N/A' }}</td>
                                    <td>{{ optional($contract->end_date)->format('d/m/Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No contrat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <h5 class="mb-0">My payments</h5>
    <div class="row mt-4">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Due Date</th>
                                <th>Expected(FCFA)</th>
                                <th>Paid(FCFA)</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr class="{{ $payment->isOverdue() ? 'table-danger' : '' }}">
                                    <td>#{{ $payment->id }}</td>
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
                                        <div class="d-flex flex-row gap-1 text-center">
                                            {{-- PAY --}}
                                            @if ($payment->status->code === 'pending' || $payment->status->code === 'overdue')
                                                <a href="{{ route('payments.pay.form', $payment) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Pay
                                                </a>
                                            @else
                                                #
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
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing
                            {{ $payments->firstItem() ?? 0 }}
                            to {{ $payments->lastItem() ?? 0 }} of {{ $payments->total() }} payments</div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li
                                        class="dt-paging-button page-item {{ $payments->onFirstPage() ? 'disabled' : '' }}">
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
                                                <a class="page-link"
                                                    href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $payments->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li
                                        class="dt-paging-button page-item {{ $payments->hasMorePages() ? '' : 'disabled' }}">
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
    </div>
@endif
