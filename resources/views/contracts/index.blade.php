@extends('layouts.app')
@section('content')
    <div class="col-xxl-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex justify-content-start">
                <h5 class="m-1">Contracts</h5>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('contracts.create') }}" class="btn rounded btn-primary">New Contract</a>
            </div>
        </div>
        <div class="card my-5">
            <!-- Status Filter -->
            <div class="row m-3 gap-3">
                <form method="GET" action="{{ route('contracts.index') }}" class="d-flex flex-wrap" x-data>
                    <div class="d-md-flex justify-content-between align-items-end dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-length">
                            <label for="contract-status" class="form-label">Status
                                <select name="status" id="contract-status"
                                    class="form-select form-select-sm d-inline-block ms-2" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>
                                        Overdue</option>
                                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>
                                        Archived</option>
                                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>
                                        Expired</option>
                                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-end dt-layout-end col-md-auto gap-2 flex-wrap">
                        <div>
                            <label for="contract-search" class="form-label">Search:</label>
                            <input type="search" name="search" id="contract-search" class="form-control form-control-sm"
                                placeholder="Name, Number, Rent..." value="{{ request('search') }}"
                                @input.debounce.500ms="$el.form.submit()">
                        </div>
                    </div>
                </form>
            </div>
            @if ($contracts->count() > 0)
                <div class="table-responsive table-hover text-nowrap">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Student</th>
                                <th>Rooms</th>
                                <th>Status</th>
                                <th>Billing Periods</th>
                                <th>Rent Amount(FCFA)</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($contracts as $contract)
                                <tr>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $contract->user->firstname }} {{ $contract->user->lastname }}</span>
                                    </td>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>({{ $contract->room->floor->building->name }})/Floor
                                            {{ $contract->room->floor->number }}/Room
                                            {{ $contract->room->number }}</span>
                                    </td>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        @if ($contract->status->code === 'overdue')
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            @switch($contract->status->code)
                                                @case('pending')
                                                    <span class="badge bg-label-warning">{{ $contract->status->label }}</span>
                                                @break

                                                @case('active')
                                                    <span class="badge bg-label-success">{{ $contract->status->label }}</span>
                                                @break

                                                @case('expired')
                                                    <span class="badge bg-label-secondary">{{ $contract->status->label }}</span>
                                                @break

                                                @case('archived')
                                                    <span class="badge bg-label-dark">{{ $contract->status->label }}</span>
                                                @break

                                                @default
                                                    <span
                                                        class="badge bg-label-info">{{ $contract->status->label ?? 'Unknown' }}</span>
                                            @endswitch
                                        @endif

                                    </td>
                                    <td>
                                        {{ $contract->billingPeriod->label }}
                                    </td>
                                    <td>
                                        {{ $contract->rent_amount }}
                                    </td>
                                    <td>
                                        {{ $contract->start_date }}
                                    </td>
                                    <td>
                                        {{ $contract->end_date }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('contracts.show', $contract) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>View</a>
                                                <a class="dropdown-item" href="{{ route('contracts.edit', $contract) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i> Edit</a>
                                                <hr class="dropdown-divider">
                                                <form method="POST" action="{{ route('contracts.archive', $contract) }}">
                                                    @method('PATCH')
                                                    @csrf
                                                    <button class="dropdown-item text-danger" type="submit">
                                                        <i class="icon-base bx bx-trash me-1"></i>Archive
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <!-- Pagination -->
                <div class="row mx-3 justify-content-between">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing
                            {{ $contracts->firstItem() ?? 0 }}
                            to {{ $contracts->lastItem() ?? 0 }} of {{ $contracts->total() }} contracts</div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li
                                        class="dt-paging-button page-item {{ $contracts->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $contracts->previousPageUrl() }}"
                                            {{ $contracts->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($contracts->getUrlRange(1, $contracts->lastPage()) as $page => $url)
                                        @if ($page == $contracts->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif (
                                            $page == 1 ||
                                                $page == $contracts->lastPage() ||
                                                ($page >= $contracts->currentPage() - 2 && $page <= $contracts->currentPage() + 2))
                                            <li class="dt-paging-button page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $contracts->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li
                                        class="dt-paging-button page-item {{ $contracts->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $contracts->nextPageUrl() }}"
                                            {{ !$contracts->hasMorePages() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center mb-5">
                    <div class="demo-inline-spacing mx-5 align-items-center">
                        <p> <strong>No contract found.</strong></p>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
