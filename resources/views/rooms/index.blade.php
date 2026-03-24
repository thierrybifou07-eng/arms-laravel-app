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
                                                <a class="dropdown-item" href="{{ route('buildings.floors.index', $floor) }}"><i
                                                        class="icon-base bx bx-show-alt me-1"></i> View</a>
                                                <a class="dropdown-item" href="{{ route('floors.rooms.edit', [$floor, $room]) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i> Edit</a>
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