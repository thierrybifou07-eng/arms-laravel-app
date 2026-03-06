@extends('layouts.app')

@section('content')
<div class="container-lg my-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-6">RBAC Management Dashboard</h1>
            <p class="text-muted">Manage roles, permissions, and user assignments</p>
        </div>
        <div class="col-md-4 text-end">
            @auth
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <p class="mb-2"><strong>Current User:</strong></p>
                        <p class="mb-1">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p>
                        <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Dashboard Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Roles</h5>
                    <h2 class="text-primary">{{ $totalRoles ?? 0 }}</h2>
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary mt-3">View Roles</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Permissions</h5>
                    <h2 class="text-success">{{ $totalPermissions ?? 0 }}</h2>
                    <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-success mt-3">View Permissions</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users</h5>
                    <h2 class="text-info">{{ $totalUsers ?? 0 }}</h2>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-info mt-3">View Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Your Permissions</h5>
                    <h2 class="text-warning">{{ auth()->user()->getPermissions()->count() ?? 0 }}</h2>
                    <a href="{{ route('users.show', auth()->id()) }}" class="btn btn-sm btn-warning mt-3">View Yours</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Links -->
    <div class="row mb-5">
        <div class="col-md-12">
            <h4 class="mb-4">Quick Access</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Roles Management</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('roles.index') }}" class="text-decoration-none">📋 View All Roles</a></li>
                                <li><a href="{{ route('roles.create') }}" class="text-decoration-none">➕ Create New Role</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Permissions Management</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('permissions.index') }}" class="text-decoration-none">📋 View All Permissions</a></li>
                                <li><a href="{{ route('permissions.create') }}" class="text-decoration-none">➕ Create New Permission</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Permissions Table -->
    @auth
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Your Roles & Permissions</h5>
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->roles->count() > 0)
                            <h6 class="mb-3">Your Roles:</h6>
                            <div class="mb-4">
                                @foreach (auth()->user()->roles as $role)
                                    <span class="badge bg-primary me-2">{{ $role->label }}</span>
                                @endforeach
                            </div>

                            <h6 class="mb-3">Your Permissions:</h6>
                            <div class="row">
                                @foreach (auth()->user()->getPermissions() as $permission)
                                    <div class="col-md-4 mb-2">
                                        <small><span class="badge bg-success">✓ {{ $permission->label }}</span></small>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                You don't have any roles assigned yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endauth
</div>
@endsection
