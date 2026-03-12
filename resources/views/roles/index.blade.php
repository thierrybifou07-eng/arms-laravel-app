@extends('layouts.app')
@section('content')
    <div class="card m-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($roles->count() > 0)
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Label</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($roles as $role)
                            <tr>
                                <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                    <span>{{ $role->label }}</span>
                                </td>
                                <td> {{ $role->created_at }}
                                </td>
                                <td>
                                    {{ $role->updated_at }}
                                </td>
                                <td>
                                    <div class="demo-inline-spacing">
                                        <button type="button" class="btn btn-outline-dark">
                                            <a class="active" href="{{ route('roles.show', $role) }}">
                                                View
                                            </a>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning">
                                            <a href="{{ route('roles.edit', $role) }}">
                                                Edit
                                            </a>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <h5>No roles found</h5>
            </div>
        @endif
    </div>
@endsection
