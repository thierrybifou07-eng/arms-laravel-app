@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="d-flex align-items-start row">
            <div class="col-sm-7">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-3">Congratulations John! 🎉</h5>
                    <p class="mb-6">
                        You have done 72% more sales today.<br>Check your new badge in your
                        profile.
                    </p>

                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">View
                        Badges</a>
                </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-6">
                    <img src="{{ asset('admin-template/assets') }}/img/illustrations/man-with-laptop.png" height="175"
                        alt="View Badge User">
                </div>
            </div>
        </div>
    </div>
    <div cclass="col-xxl-12">
        <div class="card my-5">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($floors->count() > 0)
                <div class="table-responsive text-nowrap table-hover">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Number</th>
                                <th>Capacity</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
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
                                        {{ $floor->updated_at }}
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
                                                <a class="dropdown-item" href="{{ route('floors.rooms.index', $floor) }}"><i
                                                        class="icon-base bx bx-show-alt me-1"></i> View</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('buildings.floors.edit', [$building, $floor]) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i> Edit</a>
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
            @else
                <div class="text-center py-5">
                    <div class="demo-inline-spacing mx-5">

                        <a class="btn rounded-pill btn-primary" href="{{ route('buildings.floors.create', $building) }}">
                            No floor found, create one. </a>
                    </div>
                </div>
            @endif
        </div>
        @if ($floors->count() > 0)
            <div class="demo-inline-spacing mx-5">
                <a href="{{ route('buildings.floors.create', $building) }}" class="btn rounded-pill btn-primary">New
                    Floor</a>
            </div>
        @endif
    </div>
@endsection
