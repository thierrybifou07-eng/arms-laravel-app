@extends('layouts.app')
@section('content')
<div class="col-xxl-12">
<div class="card my-5">

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
                                                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Make
                                            </button>
                                            <ul class="dropdown-menu" style="">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('users.show', $user) }}">
                                                        <i class="icon-base bx bx-show-alt me-1"></i>view</a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('users.edit', $user) }}"><i
                                                            class="icon-base bx bx-edit me-1"></i> Edit</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('users.destroy', $user) }}"><i
                                                            class="icon-base bx bx-trash me-1"></i> Delete</a></li>
                                                <li>
                                            </ul>
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
</div>
@endsection
