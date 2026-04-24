<div class="card mb-4 text-center">
    <div class="card-body">
        <img src="{{ $user->avatar() }}" alt="{{ $user->firstname }}" class="rounded-circle mb-3" width="100"
            height="100">
        <h5 class="card-title mb-1">{{ $user->firstname }} {{ $user->lastname }}</h5>
        <p class="text-muted mb-3">{{ $user->email }}</p>

        <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">
            @include('super_admin.users.partials.show.badges.role', ['role' => $userRole])
            @include('super_admin.users.partials.show.badges.status', ['status' => $user->userStatus])
            <span class="badge bg-label-secondary">
                {{ $user->email_verified_at ? 'Email verified' : 'Email not verified' }}
            </span>
        </div>

        <div class="row g-2 text-start mt-1">
            <div class="col-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted d-block">Contracts</small>
                    <strong>{{ $user->contracts->count() }}</strong>
                </div>
            </div>
            <div class="col-6">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted d-block">Residences</small>
                    <strong>{{ $user->residences->count() }}</strong>
                </div>
            </div>
        </div>

        <div class="gap-2 d-flex flex-column mt-4">
            @if (auth()->id() !== $user->id && !$user->hasRole(\App\Models\Role::SUPER_ADMIN))
                <a href="{{ route('super_admin.user.roles.edit', $user) }}" class="btn btn-sm btn-outline-primary">
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

<div class="card mb-4">
    <div class="card-header pb-0">
        <h6 class="card-title mb-0">
            <i class="bx bx-info-circle me-2"></i>About
        </h6>
    </div>
    <div class="card-body">
        <ul class="list-unstyled mb-0">
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
            <li class="mb-0">
                <small class="text-muted d-block mb-1">Email Verification</small>
                <strong>{{ $user->email_verified_at?->format('M d, Y H:i') ?? 'Pending' }}</strong>
            </li>
        </ul>
    </div>
</div>

<div class="card">
    <div class="card-header pb-0">
        <h6 class="card-title mb-0">
            <i class="bx bx-pulse me-2"></i>Account Health
        </h6>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-3">
            <div>
                <small class="text-muted d-block">Current status</small>
                @include('super_admin.users.partials.show.badges.status', ['status' => $user->userStatus])
            </div>
            <i class="bx bx-user-check fs-3 text-primary"></i>
        </div>

        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-3">
            <div>
                <small class="text-muted d-block">Role coverage</small>
                <span>{{ $userRole?->label ?? 'Not assigned yet' }}</span>
            </div>
            <i class="bx bx-shield-quarter fs-3 text-success"></i>
        </div>

        <div class="d-flex justify-content-between align-items-center border rounded p-3">
            <div>
                <small class="text-muted d-block">Residence scope</small>
                <span>{{ $user->residences->pluck('name')->take(2)->join(', ') ?: 'No residence assigned' }}</span>
            </div>
            <i class="bx bx-building-house fs-3 text-warning"></i>
        </div>
    </div>
</div>
