@extends('layouts.app')
@section('content')
    <div cclass="col-xxl-12">
        <div class="card my-5">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($buildings->count() > 0)
                <div class="table-responsive text-nowrap table-hover">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Capacity</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($buildings as $building)
                                <tr>
                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $building->name }}</span>
                                    </td>

                                    <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $building->address }}</span>
                                    </td>
                                    <td> {{ $building->capacity }}
                                    </td>
                                    <td>
                                        {{ $building->created_at }}
                                    </td>
                                    <td>
                                        {{ $building->updated_at }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary me-1">{{ $building->status->label }}</span>

                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('buildings.floors.index', $building) }}"><i
                                                        class="icon-base bx bx-show-alt me-1"></i> View</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('residences.buildings.edit', [$residence, $building]) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i> Edit</a>
                                                <form method="POST"
                                                    action="{{ route('residences.buildings.destroy', [$residence, $building]) }}">
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
                    <hr>
                </div>
                <!-- Pagination -->
                <div class="row mx-3 justify-content-between">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <div class="dt-info" aria-live="polite" role="status">Showing {{ $buildings->firstItem() ?? 0 }}
                            to {{ $buildings->lastItem() ?? 0 }} of {{ $buildings->total() }} users</div>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-paging">
                            <nav aria-label="pagination">
                                <ul class="pagination">
                                    {{-- Previous Button --}}
                                    <li class="dt-paging-button page-item {{ $buildings->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link previous" href="{{ $buildings->previousPageUrl() }}"
                                            {{ $buildings->onFirstPage() ? 'aria-disabled=true' : '' }}>
                                            <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-sm"></i>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($buildings->getUrlRange(1, $buildings->lastPage()) as $page => $url)
                                        @if ($page == $buildings->currentPage())
                                            <li class="dt-paging-button page-item active">
                                                <span class="page-link" aria-current="page">{{ $page }}</span>
                                            </li>
                                        @elseif (
                                            $page == 1 ||
                                                $page == $buildings->lastPage() ||
                                                ($page >= $buildings->currentPage() - 2 && $page <= $buildings->currentPage() + 2))
                                            <li class="dt-paging-button page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @elseif ($page == 2 || $page == $buildings->lastPage() - 1)
                                            <li class="dt-paging-button page-item disabled">
                                                <span class="page-link ellipsis">…</span>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Button --}}
                                    <li class="dt-paging-button page-item {{ $buildings->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $buildings->nextPageUrl() }}"
                                            {{ !$buildings->hasMorePages() ? 'aria-disabled=true' : '' }}>
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

                        <a class="btn rounded-pill btn-primary"
                            href="{{ route('residences.buildings.create', $residence) }}">
                            No building found, create one. </a>
                    </div>
                </div>
            @endif
        </div>
        @if ($buildings->count() > 0)
            <div class="demo-inline-spacing mx-5">
                <a href="{{ route('residences.buildings.create', $residence) }}" class="btn rounded-pill btn-primary">New
                    Building</a>
            </div>
        @endif
    </div>
@endsection
