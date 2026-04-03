@extends('layouts.app')
@section('content')

    <div class="container-lg py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->firstname }} {{ $user->lastname }}</strong>
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->phone ?? 'N/A' }}
                                </td>
                                <td>
                                    @if ($user->roles->count() > 0)
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-primary">{{ $role->label }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-secondary">No roles</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->userStatus)
                                        <span class="badge bg-info">{{ $user->userStatus->label ?? 'Unknown' }}</span>
                                    @else
                                        <span class="badge bg-secondary">No Status</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">
                                         View
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                         Edit
                                    </a>
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
