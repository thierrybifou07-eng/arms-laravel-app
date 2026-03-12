@extends('layouts.app')
@section('content')
<div class="card m-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($users->count() > 0)
        <div class="text-nowrap">
            <table class="table-responsive table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Roles</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($users as $user)
                        <tr>
                            <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                <span>{{ $user->firstname }}</span>
                            </td>
                            <td><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                <span>{{ $user->lastname }}</span>
                            </td>
                            <td> {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->phone ?? 'N/A' }}
                            </td>
                            <td>
                                @if ($user->roles->count() > 0)
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-label-primary me-1">{{ $role->label }}</span>
                                    @endforeach
                                @else
                                    <span class="badge bg-label-info me-1">No roles</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->userStatus)
                                    <span
                                        class="badge bg-label-primary me-1">{{ $user->userStatus->label ?? 'UnKnown' }}</span>
                                @else
                                <span class="badge bg-label-info me-1">No Status</span>
                                @endif
                                
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i
                                            class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('users.show', $user) }}"><i
                                                class="icon-base bx bx-edit-alt me-1"></i> View</a>
                                        <a class="dropdown-item" href="{{ route('users.edit', $user) }}"><i
                                                class="icon-base bx bx-trash me-1"></i> Edit</a>
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
            <h5>No users found</h5>
        </div>
    @endif
</div>
@endsection
