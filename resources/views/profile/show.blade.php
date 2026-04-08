@extends('layouts.app')
@section('content')
    <div class="row fv-plugins-icon-container">
        <div class="col-md-12">
            @php
                $statusCode = $user->userStatus?->code;
            @endphp
            @if($statusCode === 'pending')
                <div class="alert alert-warning">
                    Your account is waiting to be activated by the administration.
                    Some features remain limited.
                </div>
            @elseif($statusCode === 'active')
                <div class="alert alert-success">
                    Your account is active. You can access all the features allowed by your roles.
                </div>
            @elseif($statusCode === 'suspended')
                <div class="alert alert-danger">
                    Your account is suspended. Contact the administration.
                </div>
            @endif
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="card shadow-sm p-4 text-center mb-5 h-100">
                        <div class="card-body">

                            <div class="rounded-circle bg-light mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 96px; height: 96px; font-size: 2rem; font-weight: 700;">
                                {{ strtoupper(substr($user->firstname ?? $user->name ?? 'U', 0, 1)) }}
                            </div>

                            <h2 class="h5 mb-1">{{ $user->firstname }} {{ $user->lastname }}</h2>
                            <p class="text-muted mb-2">{{ $user->email }}</p>

                            @php
                                $statusCode = $user->userStatus?->code;
                            @endphp

                            @if($statusCode === 'pending')
                                <span class="badge bg-warning text-dark">Pending account</span>
                            @elseif($statusCode === 'active')
                                <span class="badge bg-success">Compte actif</span>
                            @elseif($statusCode === 'suspended')
                                <span class="badge bg-danger">Suspended Account</span>
                            @else
                                <span class="badge bg-secondary">Unknown status</span>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card shadow-sm mb-5 h-100">
                        <div class="card-header bg-white">
                            <strong>System Information</strong>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <div class="text-muted small">First name</div>
                                    <div class="fw-semibold">{{ $user->firstname ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Name</div>
                                    <div class="fw-semibold">{{ $user->lastname ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Email</div>
                                    <div class="fw-semibold">{{ $user->email }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Phone</div>
                                    <div class="fw-semibold">{{ $user->phone ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Statut</div>
                                    <div class="fw-semibold">{{ $user->userStatus?->label ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Roles</div>
                                    <div class="fw-semibold">
                                        @forelse($user->roles as $role)
                                            <span class="badge bg-secondary me-1 mb-1">{{ $role->label }}</span>
                                        @empty
                                            <span class="text-muted">No role assigned</span>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Create at</div>
                                    <div class="fw-semibold">{{ $user->created_at?->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small">Last updated</div>
                                    <div class="fw-semibold">{{ $user->updated_at?->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @if($statusCode === 'active')
                <div class="card shadow-sm mt-5 mb-4">
                    <div class="card-header bg-white">
                        <strong>Active User Area</strong>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                            Your account is up and running. The modules that can be accessed depend on the
                            permissions
                            related to your roles.
                        </p>
                    </div>
                </div>
            @endif
            <div class="d-flex gap-2">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit profile</a>
            </div>
        </div>
    </div>
@endsection