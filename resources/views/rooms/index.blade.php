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
                <h5 class="m-1">Rooms</h5>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('buildings.floors.index', $building) }}" class="btn rounded btn-secondary">
                    Back</a>
                <button type="button" class="btn rounded btn-primary" onclick="openModal('create-room')">
                    New Room
                </button>
            </div>
        </div>
        <div class="card my-5">
            <!-- Filters -->
            <div class="row m-3 gap-3">
                <form method="GET" action="{{ route('floors.rooms.index', $floor) }}" class="d-flex flex-wrap" x-data>
                    <div class="d-md-flex justify-content-between align-items-end dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-length">
                            <label for="room-status" class="form-label">Status
                                <select name="status" id="room-status"
                                    class="form-select form-select-sm d-inline-block ms-2" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>
                                        Available
                                    </option>
                                    <option value="busy" {{ request('status') === 'busy' ? 'selected' : '' }}>
                                        Busy</option>
                                    <option value="renew" {{ request('status') === 'renew' ? 'selected' : '' }}>
                                        Renewal</option>
                                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>
                                        Closed</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-end dt-layout-end col-md-auto gap-2 flex-wrap">
                        <div>
                            <label for="room-search" class="form-label">Search:</label>
                            <input type="search" name="search" id="room-search" class="form-control form-control-sm"
                                placeholder="Number..." value="{{ request('search') }}"
                                @input.debounce.500ms="$el.form.submit()">
                        </div>
                    </div>
                </form>
            </div>

            @if ($rooms->count() > 0)
                <div class="table-responsive text-nowrap table-hover">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Number</th>
                                <th>Capacity</th>
                                <th>Rent(FCFA)</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($rooms as $room)
                                <tr>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $room->number }}</span>
                                    </td>
                                    <td> {{ $room->capacity }}
                                    </td>
                                    <td> {{ $room->rent }}
                                    </td>
                                    <td>
                                        {{ $room->created_at }}
                                    </td>
                                    <td>
                                        @switch($room->status->code ?? '')
                                            @case('busy')
                                                <span class="badge bg-label-primary">{{ $room->status->label ?? 'Busy' }}</span>
                                            @break

                                            @case('available')
                                                <span
                                                    class="badge bg-label-success">{{ $room->status->label ?? 'Available' }}</span>
                                            @break

                                            @case('closed')
                                                <span
                                                    class="badge bg-label-secondary">{{ $room->status->label ?? 'Closed' }}</span>
                                            @break

                                            @default
                                                <span class="badge bg-label-light">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item"
                                                    onclick="openModal('room-show-{{ $room->id }}')">
                                                    <i class="icon-base bx bx-show-alt me-1"></i> Show</button>
                                                <button type="button" class="dropdown-item"
                                                    onclick="openModal('edit-room-{{ $room->id }}')">
                                                    <i class="icon-base bx bx-edit me-1"></i>Edit</button>
                                                <hr class="dropdown-divider">
                                                <form method="POST"
                                                    action="{{ route('floors.rooms.destroy', [$floor, $room]) }}">
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
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $rooms->firstItem() ?? 0 }}
                            to {{ $rooms->lastItem() ?? 0 }} of {{ $rooms->total() }} entries</div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li class="dt-paging-button page-item {{ $rooms->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $rooms->previousPageUrl() }}"
                                            {{ $rooms->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($rooms->getUrlRange(1, $rooms->lastPage()) as $page => $url)
                                        @if ($page == $rooms->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif (
                                            $page == 1 ||
                                                $page == $rooms->lastPage() ||
                                                ($page >= $rooms->currentPage() - 2 && $page <= $rooms->currentPage() + 2))
                                            <li class="dt-paging-button page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $rooms->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li class="dt-paging-button page-item {{ $rooms->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $rooms->nextPageUrl() }}"
                                            {{ !$rooms->hasMorePages() ? 'aria-disabled=true' : '' }}>
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
                    <h5>No room found</h5>
                </div>
            @endif
        </div>

        <div class="demo-inline-spacing mx-5">
            <a href="{{ route('floors.rooms.create', $floor) }}" class="btn rounded-pill btn-secondary">Back</a>
        </div>

    </div>

    {{-- Create Modal --}}
    @include('rooms.form-modal', ['floor' => $floor, 'room' => null, 'statuses' => $statuses])

    {{-- Edit Modals --}}
    @foreach ($rooms as $room)
        @include('rooms.form-modal', [
            'floor' => $floor,
            'room' => $room,
            'statuses' => $statuses ?? \App\Models\RoomStatus::all(),
        ])
        @include('rooms.show-modal', ['floor' => $floor, 'room' => $room])
    @endforeach

@endsection
