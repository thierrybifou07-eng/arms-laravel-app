@extends('layouts.app')
@section('content')
    <div class="col-xxl-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card my-5">

            @if ($rooms->count() > 0)
                <div class="table-responsive text-nowrap table-hover">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Number</th>
                                <th>Capacity</th>
                                <th>Rent(FCFA)</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
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
                                        {{ $room->updated_at }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary me-1">{{ $room->status->label }}</span>

                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('floors.rooms.show', [$floor, $room]) }}"><i
                                                        class="icon-base bx bx-show-alt me-1"></i> Show</a>
                                                <a class="dropdown-item" href="{{ route('floors.rooms.edit', [$floor, $room]) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i> Edit</a>
                                                <hr class="dropdown-divider">
                                                <form method="POST" action="{{ route('floors.rooms.destroy', [$floor, $room]) }}">
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

                <!-- Pagination -->
                <div class="row mx-3 justify-content-between mt-3">
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $rooms->firstItem() ?? 0 }}
                            to {{ $rooms->lastItem() ?? 0 }} of {{ $rooms->total() }} entries</div>
                    </div>
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li class="dt-paging-button page-item {{ $rooms->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $rooms->previousPageUrl() }}" {{ $rooms->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($rooms->getUrlRange(1, $rooms->lastPage()) as $page => $url)
                                        @if ($page == $rooms->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif ($page == 1 || $page == $rooms->lastPage() || ($page >= $rooms->currentPage() - 2 && $page <= $rooms->currentPage() + 2))
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
                                        <a class="page-link next" href="{{ $rooms->nextPageUrl() }}" {{ !$rooms->hasMorePages() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="demo-inline-spacing mx-5">

                        <a class="btn rounded-pill btn-primary" href="{{ route('floors.rooms.create', $floor) }}">
                            No room found, create one. </a>
                    </div>
                </div>
            @endif
        </div>

        <div class="demo-inline-spacing mx-5">
            <a href="" class="btn rounded-pill btn-secondary">Back</a>
            @if ($rooms->count() > 0)
                <a href="{{ route('floors.rooms.create', $floor) }}" class="btn rounded-pill btn-primary">New
            Room</a>@endif
        </div>

    </div>
@endsection