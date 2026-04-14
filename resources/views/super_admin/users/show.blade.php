@extends('layouts.app')
@section('content')
    <div class="col-xxl  col-lg-12 col-md-12 flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary mb-2">
                            Back to Users
                        </a>
                        <h3 class="mb-0">User Details</h3>
                    </div>
                    <div class="btn-group" role="group">
                        @if (auth()->id() !== $user->id && !$user->hasRole('super_admin'))
                            <form method="POST" action="{{ route('users.destroy', $user) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="bx bx-trash me-1"></i>Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Profile Info -->
            <div class="col-lg-4 mb-4">
                <!-- User Card -->
                <div class="card mb-4 text-center">
                    <div class="card-body">
                        <img src="{{ $user->avatar() }}" alt="{{ $user->firstname }}" class="rounded-circle mb-3"
                            width="100">
                        <h5 class="card-title">{{ $user->firstname }}</h5>
                        <p class="text-muted mb-3">{{ $user->email }}</p>
                        <!-- Action Buttons -->
                        <div class="gap-2 d-flex flex-column mt-4">
                            @if (auth()->id() !== $user->id)
                                <a href="{{ route('super_admin.user.roles.edit', $user) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-edit me-1"></i>Manage Roles
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#changeStatusModal">
                                    <i class="bx bx-refresh me-1"></i>Change Status
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- About User Card -->
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-info-circle me-2"></i>About
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <small class="text-muted d-block mb-1">Full Name</small>
                                <strong>{{ $user->firstname }} {{ $user->lastname }}</strong>
                            </li>
                            <li class="mb-3">
                                <small class="text-muted d-block mb-1">Email</small>
                                <strong>{{ $user->email }}</strong>
                            </li>
                            <li class="mb-3">
                                <small class="text-muted d-block mb-1">Phone</small>
                                <strong>{{ $user->phone ?? 'N/A' }}</strong>
                            </li>
                            <li class="mb-3">
                                <small class="text-muted d-block mb-1">Joined</small>
                                <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                            </li>
                            <li class="mb-3">
                                <small class="text-muted d-block mb-1">Last update</small>
                                <strong>{{ $user->updated_at->format('M d, Y') }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column - Detailed Info -->
            <div class="col-lg-8">
                <!-- Roles & Permissions Card -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-crown me-2"></i>Roles
                        </h6>
                        @if (auth()->id() !== $user->id)
                            <a href="{{ route('super_admin.user.roles.edit', $user) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-edit me-1"></i>Edit
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @php
                            $userRole = $user->getRole();
                        @endphp

                        @if ($userRole)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Role</th>
                                            <th>Assigned Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>{{ $userRole->label }}</strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $userRole->pivot->created_at?->format('M d, Y H:i') ?? 'N/A' }}
                                                </small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                <i class="bx bx-info-circle me-2"></i>
                                This user has no role assigned.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status History Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-history me-2"></i>User Status
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <p class="text-muted small mb-1">Current Status</p>
                                    <h5 class="mb-0">
                                        @if ($user->userStatus?->code === 'active')
                                            <span class="badge bg-success"><i class="bx bx-check-circle me-1"></i>{{ $user->userStatus->label }}</span>
                                        @elseif ($user->userStatus?->code === 'pending')
                                            <span class="badge bg-warning"><i class="bx bx-time me-1"></i>{{ $user->userStatus->label }}</span>
                                        @elseif ($user->userStatus?->code === 'disabled')
                                            <span class="badge bg-danger"><i class="bx bx-block me-1"></i>{{ $user->userStatus->label }}</span>
                                        @else
                                            <span
                                                class="badge bg-secondary">{{ $user->userStatus?->label ?? 'N/A' }}</span>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <p class="text-muted small mb-1">Active Contracts</p>
                                    <h5 class="mb-0">{{ $user->contracts->where('status.code', 'active')->count() }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center p-3 bg-light rounded">
                                    <p class="text-muted small mb-1">Total Contracts</p>
                                    <h5 class="mb-0">{{ $user->contracts->count() }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contracts Card -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bx bx-file-blank me-2"></i>Contracts
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($user->contracts->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Contract ID</th>
                                            <th>Room</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->contracts->take(5) as $contract)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('contracts.show', $contract) }}"
                                                        class="text-primary">
                                                        #{{ $contract->id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <small>
                                                        {{ $contract->room?->floor?->building?->name ?? 'N/A' }}
                                                        / F{{ $contract->room?->floor?->number ?? 'N/A' }}
                                                        / R{{ $contract->room?->number ?? 'N/A' }}
                                                    </small>
                                                </td>
                                                <td>
                                                    @switch($contract->status->code)
                                                        @case('pending')
                                                            <span class="badge bg-warning">{{ $contract->status->label }}</span>
                                                        @break

                                                        @case('active')
                                                            <span class="badge bg-success">{{ $contract->status->label }}</span>
                                                        @break

                                                        @case('overdue')
                                                            <span class="badge bg-danger">{{ $contract->status->label }}</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-secondary">{{ $contract->status->label }}</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <small
                                                        class="text-muted">{{ $contract->created_at->format('M d, Y') }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($user->contracts->count() > 5)
                                <small class="text-muted">
                                    <em>Showing 5 of {{ $user->contracts->count() }} contracts</em>
                                </small>
                            @endif
                        @else
                            <div class="alert alert-info" role="alert">
                                <i class="bx bx-info-circle me-2"></i>
                                This student has no contracts.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Status Modal -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('users.changeStatus', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Change User Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_status_id" class="form-label">Select Status</label>
                            <select class="form-select @error('user_status_id') is-invalid @enderror" id="user_status_id"
                                name="user_status_id" required>
                                <option value="">-- Select a status --</option>
                                @forelse (\App\Models\UserStatus::all() as $status)
                                    <option value="{{ $status->id }}"
                                        {{ $user->user_status_id === $status->id ? 'selected' : '' }}>
                                        {{ $status->label }}
                                    </option>
                                @empty
                                    <option disabled>No statuses available</option>
                                @endforelse
                            </select>
                            @error('user_status_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check me-1"></i>Change Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
