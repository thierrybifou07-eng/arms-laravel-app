@extends('layouts.app')

@section('content')
    <div class="col-xxl col-lg-12 col-md-12 flex-grow-1">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h3 class="mb-0">
                <i class="bx bx-list-check me-2"></i>Audit Logs
            </h3>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="bx bx-download me-1"></i>Export
                </button>
                <button type="button" class="btn btn-outline-danger" id="deleteMultipleBtn" disabled>
                    <i class="bx bx-trash me-1"></i>Delete Selected
                </button>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Filters Card -->
        <div class="card mb-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Filters</h5>
                <a href="{{ route('super_adminaudits.index') }}" class="btn btn-sm btn-link">Clear All</a>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('super_adminaudits.index') }}" id="filterForm" class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="URL or Tags"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="event" class="form-label">Event</label>
                        <select class="form-select" id="event" name="event">
                            <option value="">All Events</option>
                            @foreach ($events as $evt)
                                <option value="{{ $evt }}" {{ request('event') == $evt ? 'selected' : '' }}>
                                    {{ ucfirst($evt) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="model" class="form-label">Model</label>
                        <select class="form-select" id="model" name="model">
                            <option value="">All Models</option>
                            @foreach ($models as $mdl)
                                <option value="App\Models\{{ $mdl }}"
                                    {{ request('model') == 'App\Models\\' . $mdl ? 'selected' : '' }}>
                                    {{ $mdl }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-search me-1"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Audits Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="table-dark">
                            <th>
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Event</th>
                            <th>Model</th>
                            <th>IP Address</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($audits as $audit)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input audit-checkbox"
                                        value="{{ $audit->id }}">
                                </td>
                                <td>
                                    <span class="badge bg-info">#{{ $audit->id }}</span>
                                </td>
                                <td>
                                    @if ($audit->user)
                                        {{ $audit->user->email }}
                                        <br>
                                        <small class="text-muted">{{ $audit->user->firstname }}
                                            {{ $audit->user->lastname }}</small>
                                    @else
                                        <span class="text-muted"><em>System</em></span>
                                    @endif
                                </td>
                                <td>
                                    @switch($audit->event)
                                        @case('created')
                                            <span class="badge bg-success">{{ ucfirst($audit->event) }}</span>
                                        @break

                                        @case('updated')
                                            <span class="badge bg-info">{{ ucfirst($audit->event) }}</span>
                                        @break

                                        @case('deleted')
                                            <span class="badge bg-danger">{{ ucfirst($audit->event) }}</span>
                                        @break

                                        @case('restored')
                                            <span class="badge bg-warning">{{ ucfirst($audit->event) }}</span>
                                        @break

                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($audit->event) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <small>{{ class_basename($audit->auditable_type) }}</small>
                                </td>
                                <td>
                                    <small>{{ $audit->ip_address ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <small>{{ $audit->created_at->format('M d, Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('super_adminaudits.show', $audit) }}">
                                                <i class="bx bx-show-alt me-1"></i>View</a>
                                            <hr class="dropdown-divider">
                                            <button type="button" data-audit-id="{{ $audit->id }}"
                                                class="dropdown-item text-danger delete-btn">
                                                <i class="bx bx-trash me-1"></i>Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bx bx-box text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mt-2">No audit records found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($audits->hasPages())
                    <!-- Pagination -->
                    <div class="row mx-3 justify-content-between">
                        <div
                            class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                            <div class="dt-info" aria-live="polite" role="status">Showing {{ $audits->firstItem() ?? 0 }}
                                to {{ $audits->lastItem() ?? 0 }} of {{ $audits->total() }} audits</div>
                        </div>
                        <div
                            class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                            <div class="dt-paging">
                                <nav aria-label="pagination">
                                    <ul class="pagination">
                                        {{-- Previous Button --}}
                                        <li class="dt-paging-button page-item {{ $audits->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link previous" href="{{ $audits->previousPageUrl() }}"
                                                {{ $audits->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                                <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                            </a>
                                        </li>

                                        {{-- Pagination Elements --}}
                                        @foreach ($audits->getUrlRange(1, $audits->lastPage()) as $page => $url)
                                            @if ($page == $audits->currentPage())
                                                <li class="dt-paging-button page-item active">
                                                    <span class="page-link" aria-current="page">{{ $page }}</span>
                                                </li>
                                            @elseif (
                                                $page == 1 ||
                                                    $page == $audits->lastPage() ||
                                                    ($page >= $audits->currentPage() - 2 && $page <= $audits->currentPage() + 2))
                                                <li class="dt-paging-button page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @elseif ($page == 2 || $page == $audits->lastPage() - 1)
                                                <li class="dt-paging-button page-item disabled">
                                                    <span class="page-link ellipsis">…</span>
                                                </li>
                                            @endif
                                        @endforeach

                                        {{-- Next Button --}}
                                        <li
                                            class="dt-paging-button page-item {{ $audits->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link next" href="{{ $audits->nextPageUrl() }}"
                                                {{ !$audits->hasMorePages() ? 'aria-disabled=true' : '' }}>
                                                <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Export Modal -->
        <div class="modal fade" id="exportModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('super_adminaudits.export') }}" id="exportForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Export Audit Logs</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="event" value="{{ request('event') }}">
                            <input type="hidden" name="model" value="{{ request('model') }}">
                            <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">

                            <div class="mb-3">
                                <label for="format" class="form-label">Export Format</label>
                                <select class="form-select" id="format" name="format" required>
                                    <option value="csv">CSV</option>
                                    <option value="excel">Excel (XLSX)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="export_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="export_password" name="password"
                                    placeholder="Enter your password" required>
                                <small class="text-muted">Required for security verification</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-download me-1"></i>Export
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Single Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Audit Record</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-danger mb-3">
                                <i class="bx bx-exclamation-circle me-2"></i>
                                This action cannot be undone. Please confirm your password.
                            </p>
                            <div class="mb-3">
                                <label for="delete_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="delete_password" name="password"
                                    placeholder="Enter your password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bx bx-trash me-1"></i>Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('super_admin.audits.scripts')
    @endsection
