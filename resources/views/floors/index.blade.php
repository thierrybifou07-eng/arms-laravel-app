@extends('layouts.app')
@section('content')
    <div class="col-xxl-12" x-data>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex justify-content-start">
                <h5 class="m-1">Floors</h5>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('residences.buildings.index', $residence) }}" class="btn rounded btn-secondary">Back</a>
                <button type="button" class="btn rounded btn-primary" onclick="openModal('create-floor')">
                    New Floor
                </button>
            </div>
        </div>
        <div class="card my-5">
            <!-- Filters -->
            <div class="row m-3 gap-3">
                <form method="GET" action="{{ route('buildings.floors.index', $building) }}" class="d-flex flex-wrap"
                    x-data>
                    <div class="d-md-flex justify-content-between align-items-end dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-length">
                            <label for="floor-status" class="form-label">Status
                                <select name="status" id="floor-status"
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
                            <label for="floor-search" class="form-label">Search:</label>
                            <input type="search" name="search" id="floor-search" class="form-control form-control-sm"
                                placeholder="Number..." value="{{ request('search') }}"
                                @input.debounce.500ms="$el.form.submit()">
                        </div>
                    </div>
                </form>
            </div>
            @if ($floors->count() > 0)
                <div class="table-responsive text-nowrap table-hover">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Number</th>
                                <th>Capacity</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($floors as $floor)
                                <tr>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $floor->number }}</span>
                                    </td>
                                    <td> {{ $floor->capacity }}
                                    </td>
                                    <td>
                                        {{ $floor->created_at }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary me-1">{{ $floor->status->label }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" onclick="openModal('floor-show-{{ $floor->id }}')">
                                                    <i class="icon-base bx bx-show-alt me-1"></i> Show</button>
                                                <a class="dropdown-item"
                                                    href="{{ route('floors.rooms.index', $floor) }}"><i
                                                        class="icon-base bx bx-folder me-1"></i> View Rooms</a>
                                                <button type="button" class="dropdown-item" onclick="openModal('edit-floor-{{ $floor->id }}')">
                                                    <i class="icon-base bx bx-edit me-1"></i>Edit</button>
                                                <hr class="dropdown-divider">
                                                <form method="POST"
                                                    action="{{ route('buildings.floors.destroy', [$building, $floor]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger" type="submit"><i
                                                            class="icon-base bx bx-trash me-1"></i>Delete </button>
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
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $floors->firstItem() ?? 0 }}
                            to {{ $floors->lastItem() ?? 0 }} of {{ $floors->total() }} floors</div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li class="dt-paging-button page-item {{ $floors->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $floors->previousPageUrl() }}"
                                            {{ $floors->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($floors->getUrlRange(1, $floors->lastPage()) as $page => $url)
                                        @if ($page == $floors->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif (
                                            $page == 1 ||
                                                $page == $floors->lastPage() ||
                                                ($page >= $floors->currentPage() - 2 && $page <= $floors->currentPage() + 2))
                                            <li class="dt-paging-button page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $floors->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li class="dt-paging-button page-item {{ $floors->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $floors->nextPageUrl() }}"
                                            {{ !$floors->hasMorePages() ? 'aria-disabled=true' : '' }}>
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
                    <h5>No floor found</h5>
                </div>
            @endif
        </div>

    </div>

    {{-- Create Modal --}}
    @include('floors.form-modal', ['building' => $building, 'statuses' => $statuses ?? \App\Models\FloorStatus::all()])

    {{-- Edit Modals --}}
    @foreach ($floors as $floor)
        @include('floors.form-modal', ['building' => $building, 'floor' => $floor, 'statuses' => $statuses ?? \App\Models\FloorStatus::all()])
        @include('floors.show-modal', ['building' => $building, 'floor' => $floor])
    @endforeach

@endsection
