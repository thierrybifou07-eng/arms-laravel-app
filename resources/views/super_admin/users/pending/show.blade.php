@extends('layouts.app')

@section('content')
<div class="col-xxl col-lg-6 col-md-6 col-sm-12 py-4">
    <h1 class="h4 mb-3">User informations</h1>

    <div class="card shadow-sm p-4">
        <p><strong>Name :</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Phone :</strong> {{ $user->phone }}</p>
        <p><strong>Status :</strong> {{ $user->userStatus?->label ?? 'N/A' }}</p>

        <p class="mb-1"><strong>Roles :</strong></p>
        @forelse($user->roles as $role)
            <span class="badge bg-secondary col-lg-3 col-md-3 col-sm-6 me-1 mb-1">{{ $role->label }}</span>
        @empty
            <span class="text-muted">No role</span>
        @endforelse

        <div class="mt-4">
            <a href="{{ route('activate_accountpending_users.edit', $user) }}" class="btn btn-primary">
                Assign roles and active
            </a>
            <a href="{{ route('activate_accountpending_users.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>
</div>
@endsection