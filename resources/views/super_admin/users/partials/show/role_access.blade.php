<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">
            <i class="bx bx-crown me-2"></i>Role & Access {{-- Scope --}}
        </h6>
        @if (auth()->id() !== $user->id && !$user->hasRole(\App\Models\Role::SUPER_ADMIN))
            <a href="{{ route('super_admin.user.roles.edit', $user) }}" class="btn btn-sm btn-primary">
                <i class="bx bx-edit me-1"></i>Edit
            </a>
        @endif
    </div>
    <div class="card-body">
        @if ($userRole)
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Role</th>
                            <th>Residence</th>
                            <th>Assigned Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <strong>{{ $userRole->label }}</strong>
                                    <small
                                        class="text-muted">{{ $roleInsights['scope_label'] ?? 'Assigned role' }}</small>
                                </div>
                            </td>
                            <td>
                                @if ($user->residences->isNotEmpty())
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($user->residences as $residence)
                                            <span class="badge bg-label-secondary">{{ $residence->name }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">No residence assigned</span>
                                @endif
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

            @if (!empty($roleInsights['scope_description']))
                <div class="alert alert-info m-1" role="alert">
                    <i class="bx bx-info-circle me-2"></i>{{ $roleInsights['scope_description'] }}
                </div>
            @endif
        @else
            <div class="alert alert-info mb-0" role="alert">
                <i class="bx bx-info-circle me-2"></i>
                This user has no role assigned yet. Assigning a role will unlock the right board and actions.
            </div>
        @endif
    </div>
</div>
