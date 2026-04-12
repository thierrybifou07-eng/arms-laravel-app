@extends('layouts.app')

@section('content')
    <div class="col-xxl col-lg-12 col-md-12 col-sm-12 py-4">
        <h1 class="h4 mb-3">Role Details</h1>

        <div class="card card-body">
            <p><strong>Label :</strong> {{ $role->label }}</p>

            <p class="mb-1"><strong>Permissions :</strong></p>
            @forelse($role->permissions as $permission)
                <span class="badge bg-secondary me-1 mb-1">{{ $permission->label }}</span>
            @empty
                <span class="text-muted">No permission found.</span>
            @endforelse
        </div>
    </div>
@endsection 