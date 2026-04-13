@extends('layouts.app')
@section('content')
    <div class="col-xxl-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex justify-content-start">
                <h5 class="m-1">Residences</h5>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('residences.create') }}" class="btn rounded btn-primary">New Residence</a>
            </div>
        </div>
        <div class="card my-5">
            <!-- Filters -->
            <div class="row m-3 gap-3">
                <form method="GET" action="{{ route('residences.index') }}" class="d-flex flex-wrap" x-data>
                    <div class="d-md-flex justify-content-between align-items-end dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-length">
                            <label for="residence-status" class="form-label">Status
                                <select name="status" id="residence-status"
                                    class="form-select form-select-sm d-inline-block ms-2" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>
                                        Closed</option>
                                    <option value="renew" {{ request('status') === 'renew' ? 'selected' : '' }}>
                                        Renewal</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-end dt-layout-end col-md-auto gap-2 flex-wrap">
                        <div>
                            <label for="residence-search" class="form-label">Search:</label>
                            <input type="search" name="search" id="residence-search" class="form-control form-control-sm"
                                placeholder="Name, City, Address..." value="{{ request('search') }}"
                                @input.debounce.500ms="$el.form.submit()">
                        </div>
                    </div>
                </form>
            </div>
            @if ($residences->count() > 0)
                <div class="table-responsive table-hover text-nowrap">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($residences as $residence)
                                <tr>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $residence->name }}</span>
                                    </td>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $residence->city }}</span>
                                    </td>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $residence->address }}</span>
                                    </td>
                                    <td> {{ $residence->capacity }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary me-1">{{ $residence->status->label }}</span>

                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" onclick="openModal('residence-show-{{ $residence->id }}')">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>View</button>
                                                <a class="dropdown-item"
                                                    href="{{ route('residences.buildings.index', $residence) }}">
                                                    <i class="icon-base bx bx-home-alt me-1"></i>view building(s)</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('residences.edit', $residence) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i> Edit</a>
                                                <hr class="dropdown-divider">
                                                <form method="POST"
                                                    action="{{ route('residences.destroy', $residence) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger" type="submit">
                                                        <i class="icon-base bx bx-trash me-1"></i>Delete
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
                <div class="row mx-3 justify-content-between mt-3">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $residences->firstItem() ?? 0 }}
                            to {{ $residences->lastItem() ?? 0 }} of {{ $residences->total() }} residences</div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li
                                        class="dt-paging-button page-item {{ $residences->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $residences->previousPageUrl() }}"
                                            {{ $residences->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($residences->getUrlRange(1, $residences->lastPage()) as $page => $url)
                                        @if ($page == $residences->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif (
                                            $page == 1 ||
                                                $page == $residences->lastPage() ||
                                                ($page >= $residences->currentPage() - 2 && $page <= $residences->currentPage() + 2))
                                            <li class="dt-paging-button page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $residences->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li
                                        class="dt-paging-button page-item {{ $residences->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $residences->nextPageUrl() }}"
                                            {{ !$residences->hasMorePages() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center py-5 mb-0">
                    <h5>No residence found</h5>
                </div>
            @endif
        </div>

    </div>

    {{-- Show Modals --}}
    @foreach ($residences as $residence)
        @include('residences.show-modal', ['residence' => $residence])
    @endforeach

@endsection
