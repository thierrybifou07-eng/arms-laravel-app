@if ($role)
    @php
        $roleClass = match ($role->name) {
            'super_admin' => 'bg-label-success',
            'admin' => 'bg-label-primary',
            'staff' => 'bg-label-danger',
            'student' => 'bg-label-info',
            default => 'bg-label-secondary',
        };
    @endphp

    <span class="badge {{ $roleClass }}">{{ $role->label }}</span>
@else
    <span class="badge bg-label-secondary">No role</span>
@endif
