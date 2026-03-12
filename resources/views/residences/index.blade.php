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
                            <th>Address</th>
                            <th>Capacity</th>
                            <th>Creted Date</th>
                            <th>Updated Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($residences as $residence)
                            <tr>
                                <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                    <span>{{ $residence->name }}</span>
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
                                    @if ($residence->residenceStatus)
                                        <span
                                            class="badge bg-label-primary me-1">{{ $residence->residenceStatus->label ?? 'UnKnown' }}</span>
                                    @else
                                        <span class="badge bg-label-info me-1">No Status</span>
                                    @endif

                                </td>
                                <td>
                                    <div class="demo-inline-spacing">
                                        <button type="button" class="btn btn-outline-dark">
                                            <a class="active" href="{{ route('residences.show', $residence) }}">

                                            </a>View
                                        </button>
                                        <button type="button" class="btn btn-outline-warning">
                                            <a href="{{ route('residences.edit', $residence) }}">

                                            </a>Edit
                                        </button>
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
