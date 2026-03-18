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
            <div class="table-responsive text-nowrap table-hover">
                <table class="table">
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
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('roles.show', $role) }}">
                                                <i class="icon-base bx bx-show-alt me-1"></i>view</a>
                                            <a class="dropdown-item" href="{{ route('roles.edit', $role) }}"><i
                                                    class="icon-base bx bx-edit me-1"></i> Edit</a>
                                            <hr class="dropdown-divider">
                                            <a class="dropdown-item" href="{{ route('roles.destroy', $role) }}"><i
                                                    class="icon-base bx bx-trash me-1"></i> Delete</a>
                                        </div>
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