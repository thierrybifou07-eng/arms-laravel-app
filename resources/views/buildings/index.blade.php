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
