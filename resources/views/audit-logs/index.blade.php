@extends('layouts.app')links

@section('content')
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="page-heading">
            <div class="page-title mb-2">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h4>
                            <i class="menu-icon tf-icons icon-tabler icon-tabler-history"></i>
                            Audit Logs
                        </h4>
                        <p class="text-muted">Total historical logs in the system</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Messages d'alerte --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="alert-heading d-flex align-items-center">
                    <i class="icon-tabler icon-tabler-alert-triangle me-2"></i>
                    Erreur
                </h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Search Filter</h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#passwordModal">
                                <i class="icon-tabler icon-tabler-download"></i> Export
                            </button>
                            @if (auth()->user()->hasRole('super_admin'))
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#clearLogsModal">
                                    <i class="icon-tabler icon-tabler-trash"></i> Clear Logs
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('audit-logs.index') }}" class="row">
                            <div class="col-md-3 mb-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" name="search" id="search" class="form-control"
                                    placeholder="User, details..." value="{{ request('search') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="action" class="form-label">Type of Action</label>
                                <select name="action" id="action" class="form-control">
                                    <option value="">-- All --</option>
                                    @foreach ($actions as $action)
                                        <option value="{{ $action }}" @selected(request('action') === $action)>
                                            {{ ucfirst(strtolower($action)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="audit_type" class="form-label">Type of Audit</label>
                                <select name="audit_type" id="audit_type" class="form-control">
                                    <option value="">-- All --</option>
                                    @foreach ($auditTypes as $type)
                                        <option value="{{ $type->id }}" @selected(request('audit_type') == $type->id)>
                                            {{ $type->label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="model_type" class="form-label">Type of Element</label>
                                <select name="model_type" id="model_type" class="form-control">
                                    <option value="">-- All --</option>
                                    @foreach ($modelTypes as $type)
                                        <option value="{{ $type }}" @selected(request('model_type') === $type)>
                                            {{ class_basename($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <input type="text" name="user_id" id="user_id" class="form-control"
                                    placeholder="User ID" value="{{ request('user_id') }}">
                            </div>

                            <div class="col-md-3 d-flex align-items-end mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="icon-tabler icon-tabler-search"></i> Search
                                </button>
                            </div>

                            <div class="col-md-3 d-flex align-items-end mb-3">
                                <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary w-100">
                                    <i class="icon-tabler icon-tabler-reload"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Audit Logs ({{ $auditLogs->total() }} entries)</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date/Time</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Type</th>
                                    <th>Element</th>
                                    <th>Details</th>
                                    <th>IP</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($auditLogs as $log)
                                    <tr>
                                        <td>
                                            <small class="text-muted">
                                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                                            </small>
                                        </td>
                                        <td>
                                            @if ($log->user)
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <strong>{{ $log->user->firstname }}
                                                            {{ $log->user->lastname }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $log->user->email }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary">System</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($log->action)
                                                @case('CREATE')
                                                    <span class="badge bg-success">Creation</span>
                                                @break

                                                @case('UPDATE')
                                                    <span class="badge bg-info">Modification</span>
                                                @break

                                                @case('DELETE')
                                                    <span class="badge bg-danger">Deletion</span>
                                                @break

                                                @case('LOGIN')
                                                    <span class="badge bg-primary">Login</span>
                                                @break

                                                @case('LOGOUT')
                                                    <span class="badge bg-warning">Logout</span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary">{{ $log->action }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if ($log->auditType)
                                                {{ $log->auditType->label }}
                                            @else
                                                <span class="text-muted">--</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ class_basename($log->model_type) ?? $log->auditable_type }}</small>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($log->details, 50) }}</small>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $log->ip_address }}</small>
                                        </td>
                                        <td>
                                            {{--                                             <a href="{{ route('audit-logs.show', $log) }}" class="btn btn-sm btn-info"
                                                title="Détails">
                                                <i class="icon-tabler icon-tabler-eye"></i>
                                            </a> --}}
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('audit-logs.show', $log) }}"
                                                        title="Details">
                                                        <i class="bx bx-show-alt me-1"></i>View</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No log founds matching the criteria.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($auditLogs->hasPages())
                            <!-- Pagination -->
                            <div class="row mx-3 justify-content-between">
                                <div
                                    class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                                    <div class="dt-info" aria-live="polite" role="status">Showing
                                        {{ $auditLogs->firstItem() ?? 0 }}
                                        to {{ $auditLogs->lastItem() ?? 0 }} of {{ $auditLogs->total() }} auditLogs</div>
                                </div>
                                <div
                                    class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                                    <div class="dt-paging">
                                        <nav aria-label="pagination">
                                            <ul class="pagination">
                                                {{-- Previous Button --}}
                                                <li
                                                    class="dt-paging-button page-item {{ $auditLogs->onFirstPage() ? 'disabled' : '' }}">
                                                    <a class="page-link previous" href="{{ $auditLogs->previousPageUrl() }}"
                                                        {{ $auditLogs->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                                        <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                                    </a>
                                                </li>

                                                {{-- Pagination Elements --}}
                                                @foreach ($auditLogs->getUrlRange(1, $auditLogs->lastPage()) as $page => $url)
                                                    @if ($page == $auditLogs->currentPage())
                                                        <li class="dt-paging-button page-item active">
                                                            <span class="page-link"
                                                                aria-current="page">{{ $page }}</span>
                                                        </li>
                                                    @elseif (
                                                        $page == 1 ||
                                                            $page == $auditLogs->lastPage() ||
                                                            ($page >= $auditLogs->currentPage() - 2 && $page <= $auditLogs->currentPage() + 2))
                                                        <li class="dt-paging-button page-item">
                                                            <a class="page-link"
                                                                href="{{ $url }}">{{ $page }}</a>
                                                        </li>
                                                    @elseif ($page == 2 || $page == $auditLogs->lastPage() - 1)
                                                        <li class="dt-paging-button page-item disabled">
                                                            <span class="page-link ellipsis">…</span>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- Next Button --}}
                                                <li
                                                    class="dt-paging-button page-item {{ $auditLogs->hasMorePages() ? '' : 'disabled' }}">
                                                    <a class="page-link next" href="{{ $auditLogs->nextPageUrl() }}"
                                                        {{ !$auditLogs->hasMorePages() ? 'aria-disabled=true' : '' }}>
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
            </div>
        </div>

        {{-- Modal d'Export --}}
        <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordModalLabel">
                            <i class="icon-tabler icon-tabler-lock"></i> Password Verification
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('audit-logs.export') }}" id="exportForm">
                        @csrf
                        <div class="modal-body">
                            <p class="text-muted mb-3">
                                To access the log export, please confirm your password. This is a security measure to ensure
                                that only authorized users can export sensitive audit data.:
                            </p>
                            <div class="mb-3">
                                <label for="exportPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="exportPassword" name="password" required>
                            </div>
                            <input type="hidden" name="action" value="{{ request('action') }}">
                            <input type="hidden" name="audit_type" value="{{ request('audit_type') }}">
                            <input type="hidden" name="model_type" value="{{ request('model_type') }}">
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="icon-tabler icon-tabler-download"></i> Export
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal of Suppression Logs --}}
        @if (auth()->user()->hasRole('super_admin'))
            <div class="modal fade" id="clearLogsModal" tabindex="-1" aria-labelledby="clearLogsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="clearLogsModalLabel">
                                <i class="icon-tabler icon-tabler-alert-triangle"></i> Warning !
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('audit-logs.clear') }}" id="clearForm">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                <div class="alert alert-warning" role="alert">
                                    <strong>This action is irreversible!</strong>
                                    <p class="mb-0 mt-2">All audit logs will be permanently deleted from the database.</p>
                                </div>
                                <p class="text-muted mb-3">
                                    To confirm the deletion, please enter your password:
                                </p>
                                <div class="mb-3">
                                    <label for="clearPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="clearPassword" name="password" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="icon-tabler icon-tabler-trash"></i> Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <script>
            // Clear password field on modal close
            document.getElementById('passwordModal')?.addEventListener('hidden.bs.modal', function() {
                document.getElementById('exportPassword').value = '';
            });

            document.getElementById('clearLogsModal')?.addEventListener('hidden.bs.modal', function() {
                document.getElementById('clearPassword').value = '';
            });
        </script>
    @endsection
