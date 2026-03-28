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
                <div class="table-responsive text-nowrap table-hover">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-start">First Name</th>
                                <th class="text-start">Last Name</th>
                                <th class="text-start">Email</th>
                                <th class="text-start">Phone</th>
                                <th class="text-start">Status</th>
                                <th class="text-start">Roles</th>
                                <th class="text-start">Avatars</th>
                                <th class="text-start">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center"><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $user->id }}</span>
                                    </td>
                                    <td class="text-start"><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $user->firstname }}</span>
                                    </td>
                                    <td class="text-start"><i class="icon-base fab fa-angular icon-md text-danger me-4"></i>
                                        <span>{{ $user->lastname }}</span>
                                    </td>
                                    <td class="text-start"> {{ $user->email }}
                                    </td>
                                    <td class="text-start">
                                        {{ $user->phone ?? 'N/A' }}
                                    </td>
                                    <td class="text-start">
                                        @if ($user->userStatus->code==='pending')
                                            <span class="badge bg-label-info me-1">{{ $user->userStatus->label ?? 'UnKnown' }}</span>
                                        @endif
                                        @if ($user->userStatus->code==='active')
                                            <span class="badge bg-label-primary me-1">{{ $user->userStatus->label ?? 'UnKnown' }}</span>
                                        @endif
                                        @if ($user->userStatus->code==='suspended')
                                            <span class="badge bg-label-warning me-1">{{ $user->userStatus->label ?? 'UnKnown' }}</span>
                                        @endif
                                        @if ($user->userStatus->code==='disabled')
                                            <span class="badge bg-label-secondary me-1">{{ $user->userStatus->label ?? 'UnKnown' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->roles->count() > 0)
                                            @foreach ($user->roles as $role)
                                                <div class="d-flex column">
                                                    @if ($role->name === 'student')
                                                        <span class="badge bg-label-info me-1">{{ $role->label }}</span>
                                                    @endif
                                                    @if ($role->name === 'teller')
                                                        <span class="badge bg-label-warning me-1">{{ $role->label }}</span>
                                                    @endif
                                                    @if ($role->name === 'staff')
                                                        <span class="badge bg-label-danger me-1">{{ $role->label }}</span>
                                                    @endif
                                                    @if ($role->name === 'admin')
                                                        <span class="badge bg-label-primary me-1">{{ $role->label }}</span>
                                                    @endif
                                                    @if ($role->name === 'super_admin')
                                                        <span class="badge bg-label-success me-1">{{ $role->label }}</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="badge bg-label-secondary me-1">No roles</span>
                                        @endif
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            class="avatar avatar-xs pull-up" aria-label="{{ $user->firstname }}"
                                            data-bs-original-title="{{ $user->firstname }}">
                                            <img src="{{ $user->getFirstMediaUrl('avatars') }}" alt="Avatar" width="25" height="25"
                                                class="rounded-circle">
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('users.show', $user) }}">
                                                    <i class="icon-base bx bx-show-alt me-1"></i>view</a>
                                                <a class="dropdown-item" href="{{ route('super_adminuser.roles.update', $user) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i>Assign role</a>
                                                <a class="dropdown-item" href="{{ route('activate_accountpending_users.edit', $user) }}"><i
                                                        class="icon-base bx bx-edit me-1"></i>Edit status</a>
                                                <hr class="dropdown-divider">
                                                <a class="dropdown-item" href="{{ route('users.destroy', $user) }}"><i
                                                        class="icon-base bx bx-trash me-1"></i>Delete</a>
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
    </div>
@endsection