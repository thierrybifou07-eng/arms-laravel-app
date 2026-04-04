@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Permission details</h1>

    <div class="card card-body">
        <p><strong>Name :</strong> {{ $permission->name }}</p>
        <p><strong>Label :</strong> {{ $permission->label }}</p>

        <p class="mb-1"><strong>Roles concern :</strong></p>
        @forelse($permission->roles as $role)
            <span class="badge bg-secondary me-1 mb-1">{{ $role->label }}</span>
        @empty
            <span class="text-muted">No role</span>
        @endforelse
    </div>
</div>
@endsection