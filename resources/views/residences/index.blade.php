@extends('layouts.app')
@section('content')
    <div class="card m-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($residences->count() > 0)
            <div class="text-nowrap">
                <table class="table-responsive table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Capacity</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
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
                                    {{ $residence->created_at }}
                                </td>
                                <td>
                                    {{ $residence->updated_at }}
                                </td>
                                <td>
                                    <span class="badge bg-label-primary me-1">{{ $residence->status->label }}</span>

                                </td>
                                <td>
                                    <div class="flex-md-row flex-column">

                                        <a class="btn btn-outline-dark" class="active"
                                            href="{{ route('residences.show', $residence) }}">
                                            View
                                        </a>


                                        <a class="btn btn-outline-warning"
                                            href="{{ route('residences.edit', $residence) }}">
                                            Edit
                                        </a>


                                        <a class="btn btn-outline-danger"
                                            href="{{ route('residences.destroy', $residence) }}">
                                            Delete
                                        </a>

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

                    <a class="btn rounded-pill btn-primary" href="{{ route('residences.create') }}">
                        No residence found, create one. </a>


                </div>
            </div>
        @endif
    </div>
    <div class="demo-inline-spacing mx-5">
        <button type="button" class="btn rounded-pill btn-dark">Dark</button>
    </div>
@endsection
