@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">Roles Management</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card my-5">
            <div class="table-responsive text-nowrap table-hover align-middle">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Label</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th class="text-start">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->label }}</td>
                                <td class="d-flex-wrap">
                                    @forelse($role->permissions as $permission)
                                        <div><span class="badge bg-secondary me-1 mb-1">{{ $permission->label }}</span>
                                        </div>
                                    @empty
                                        <span class="text-muted">No permission</span>
                                    @endforelse
                                </td>
                                <td>{{ $role->users_count ?? $role->users->count() }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('roles.show', $role) }}">
                                                <i class="icon-base bx bx-show-alt me-1"></i>view</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No role found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($roles->count() > 0)
                <div class="row mx-3 justify-content-between mt-3">
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $roles->firstItem() ?? 0 }}
                            to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }} entries</div>
                    </div>
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li class="dt-paging-button page-item {{ $roles->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $roles->previousPageUrl() }}" {{ $roles->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                                        @if ($page == $roles->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif ($page == 1 || $page == $roles->lastPage() || ($page >= $roles->currentPage() - 2 && $page <= $roles->currentPage() + 2))
                                            <li class="dt-paging-button page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $roles->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li class="dt-paging-button page-item {{ $roles->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $roles->nextPageUrl() }}" {{ !$roles->hasMorePages() ? 'aria-disabled=true' : '' }}>
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
@endsection