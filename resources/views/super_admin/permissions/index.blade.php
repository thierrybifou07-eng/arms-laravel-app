@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">Manage permissions</h1>
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
                            <th>Roles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->label }}</td>
                                <td class="d-flex-wrap">
                                    @forelse($permission->roles as $role)
                                        <div><span class="badge bg-secondary me-1 mb-1">{{ $role->label }}</span></div>
                                    @empty
                                        <span class="text-muted">No role</span>
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No permission found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($permissions->count() > 0)
                <div class="row mx-3 justify-content-between mt-3">
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $permissions->firstItem() ?? 0 }}
                            to {{ $permissions->lastItem() ?? 0 }} of {{ $permissions->total() }} entries</div>
                    </div>
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li class="dt-paging-button page-item {{ $permissions->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $permissions->previousPageUrl() }}" {{ $permissions->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)
                                        @if ($page == $permissions->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif ($page == 1 || $page == $permissions->lastPage() || ($page >= $permissions->currentPage() - 2 && $page <= $permissions->currentPage() + 2))
                                            <li class="dt-paging-button page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $permissions->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li class="dt-paging-button page-item {{ $permissions->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $permissions->nextPageUrl() }}" {{ !$permissions->hasMorePages() ? 'aria-disabled=true' : '' }}>
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