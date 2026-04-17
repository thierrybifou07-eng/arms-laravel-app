@extends('layouts.app')

@section('content')
    <div class="col-xxl col-lg-12 col-md-12 col-sm-12 py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="h4 mb-0">Pending users</h4>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card my-4">
            <div class="table-responsive text-nowrap table-hover">
                <table class="table table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>phone</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingUsers as $user)
                            <tr>
                                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        {{ $user->userStatus?->label ?? 'Pending' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No user in pending.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div> <!-- Pagination -->
            <div class="row mx-3 mt-3 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info" aria-live="polite" role="status">Showing {{ $pendingUsers->firstItem() ?? 0 }}
                        to {{ $pendingUsers->lastItem() ?? 0 }} of {{ $pendingUsers->total() }} pendingUsers</div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- Previous Button --}}
                                <li
                                    class="dt-paging-button page-item {{ $pendingUsers->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $pendingUsers->previousPageUrl() }}"
                                        {{ $pendingUsers->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                        <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                    </a>
                                </li>

                                {{-- Pagination Elements --}}
                                @foreach ($pendingUsers->getUrlRange(1, $pendingUsers->lastPage()) as $page => $url)
                                    @if ($page == $pendingUsers->currentPage())
                                        <li class="dt-paging-button page-item active">
                                            <span class="page-link" aria-current="page">{{ $page }}</span>
                                        </li>
                                    @elseif (
                                        $page == 1 ||
                                            $page == $pendingUsers->lastPage() ||
                                            ($page >= $pendingUsers->currentPage() - 2 && $page <= $pendingUsers->currentPage() + 2))
                                        <li class="dt-paging-button page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @elseif ($page == 2 || $page == $pendingUsers->lastPage() - 1)
                                        <li class="dt-paging-button page-item disabled">
                                            <span class="page-link ellipsis">…</span>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Button --}}
                                <li
                                    class="dt-paging-button page-item {{ $pendingUsers->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link next" href="{{ $pendingUsers->nextPageUrl() }}"
                                        {{ !$pendingUsers->hasMorePages() ? 'aria-disabled=true' : '' }}>
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
@endsection
