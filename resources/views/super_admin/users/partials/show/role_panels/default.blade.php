@include('super_admin.users.partials.show.stats_grid', ['stats' => $roleInsights['stats'] ?? []])

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="bx bx-user-voice me-2"></i>Next Recommended Action
        </h6>
    </div>
    <div class="card-body">
        <div class="alert alert-warning mb-3">
            <i class="bx bx-error-circle me-2"></i>
            This account is still missing a role. The page already keeps the common user information, but the richer
            operational view will only appear after role assignment.
        </div>

        @if (auth()->id() !== $user->id && !$user->hasRole(\App\Models\Role::SUPER_ADMIN))
            <a href="{{ route('super_admin.user.roles.edit', $user) }}" class="btn btn-primary btn-sm">
                <i class="bx bx-user-check me-1"></i>Assign a role
            </a>
        @endif
    </div>
</div>
