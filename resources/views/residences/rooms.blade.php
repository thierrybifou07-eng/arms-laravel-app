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
            <div>
                <h5 class="m-1">Rooms - {{ $residence->name }}</h5>
                <small class="text-muted">{{ $residence->city }}, {{ $residence->address }}</small>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('residences.show', $residence) }}" class="btn rounded btn-secondary">
                    Back
                </a>
            </div>
        </div>

        <div class="card my-5">
            <!-- Filters -->
            <div class="row m-3 gap-3">
                <form method="GET" action="{{ route('residences.rooms', $residence) }}" class="d-flex flex-wrap"
                    x-data>
                    <div class="d-md-flex justify-content-between align-items-end dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-length">
                            <label for="room-status" class="form-label">Status
                                <select name="status" id="room-status"
                                    class="form-select form-select-sm d-inline-block ms-2" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="">
                                        @role('staff')
                                            Reserved/Renewal
                                        @endrole
                                        @role('admin,super_admin')
                                            All
                                        @endrole
                                    </option>
                                    @foreach ($roomStatuses as $code => $label)
                                        <option value="{{ $code }}"
                                            {{ request('status') === $code ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-end dt-layout-end col-md-auto gap-2 flex-wrap">
                        <div>
                            <label for="room-search" class="form-label">Search:</label>
                            <input type="search" name="search" id="room-search"
                                class="form-control form-control-sm" placeholder="Room number..."
                                value="{{ request('search') }}" @input.debounce.500ms="$el.form.submit()">
                        </div>
                    </div>
                </form>
            </div>

            @if ($rooms->count() > 0)
                <div class="table-responsive text-nowrap table-hover">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Building</th>
                                <th>Floor</th>
                                <th>Room Number</th>
                                <th>Rent (FCFA)</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($rooms as $room)
                                <tr>
                                    <td>
                                        {{ $room->floor->building->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        Floor {{ $room->floor->number ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <i class="icon-base fab fa-angular icon-md text-danger me-2"></i>
                                        {{ $room->number }}
                                    </td>
                                    <td>
                                        {{ number_format($room->rent ?? 0, 0, ',', ' ') }}
                                    </td>
                                    <td>
                                        @switch($room->status->code ?? '')
                                            @case('busy')
                                                <span class="badge bg-label-primary">{{ $room->status->label ?? 'Busy' }}</span>
                                            @break

                                            @case('available')
                                                <span class="badge bg-label-success">{{ $room->status->label ?? 'Available' }}</span>
                                            @break

                                            @case('renew')
                                                <span class="badge bg-label-warning">{{ $room->status->label ?? 'Renewal' }}</span>
                                            @break

                                            @case('closed')
                                                <span class="badge bg-label-danger">{{ $room->status->label ?? 'Closed' }}</span>
                                            @break

                                            @default
                                                <span class="badge bg-label-secondary">{{ $room->status->label ?? 'Unknown' }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" onclick="openModal('room-show-{{ $room->id }}')"><i class="bx bx-show me-1"></i> Show</button>
                                                @can('update', $room)
                                                    <a class="dropdown-item"
                                                        href="{{ route('floors.rooms.edit', [$room->floor, $room]) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="row mx-3 justify-content-between mt-3">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $rooms->firstItem() ?? 0 }}
                            to {{ $rooms->lastItem() ?? 0 }} of {{ $rooms->total() }} rooms</div>
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
                <div class="alert alert-info m-3">
               {{--      @role('staff')
                        No rooms currently reserved or in renewal for this residence.
                    @endrole
                    @role('admin,super_admin') --}}
                        No rooms found.
{{--                     @endrole
 --}}                </div>
            @endif
        </div>
    </div>
    {{-- Show Modals --}}
    @foreach ($rooms as $room)
        @include('residences.show-modal-room', ['residence' => $residence, 'room' => $room])
    @endforeach
@endsection
