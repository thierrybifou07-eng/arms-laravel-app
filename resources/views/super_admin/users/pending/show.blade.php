@extends('layouts.app')

@section('content')
<div class="col-xxl col-md-4 col-lg-4 py-2 col-sm-12">
    <h2 class="h4 mb-2">User informations</h2>

    <div class="card shadow-sm p-4">
        <p><strong>Name :</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Phone :</strong> {{ $user->phone }}</p>
        <p><strong>Status :</strong> {{ $user->userStatus?->label ?? 'N/A' }}</p>

        <p class="mb-1"><strong>Roles :</strong></p>
        @forelse($user->roles as $role)
            <span class="badge bg-secondary me-1 mb-1 col-sm-3">{{ $role->label }}</span>
        @empty
            <span class="text-muted">No role</span>
        @endforelse

        <div class="mt-4">
            <a href="{{ route('activate_accountpending_users.edit', $user) }}" class="btn btn-primary">
                Assign roles and active
            </a>
{{--             <a href="{{ route('activate_accountpending_users.index') }}" class="btn btn-secondary">
                Back
            </a> --}}
        </div>
    </div>
</div>
@endsection