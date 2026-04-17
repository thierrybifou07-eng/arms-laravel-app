@extends('layouts.app')

@section('content')
    <div class="col-xxl col-lg-12 col-md-12 col-sm-12 py-4">

        <h1 class="h4 mb-3">
            Assign role to: {{ $user->lastname }} {{ $user->firstname }}
        </h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            $selectedResidenceId = old('residence_id', $user->managedResidence()?->id);
            $staffRoleId = $roles->firstWhere('name', \App\Models\Role::STAFF)?->id;
        @endphp

        <form method="POST" action="{{ route('super_admin.user.roles.update', $user) }}" class="card card-body">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Select a role</label>

                <div class="row">
                    @foreach ($roles as $role)
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                @php
                                    $userRole = $user->getRole();
                                    $isSelected = $userRole && $userRole->id === $role->id;
                                @endphp
                                <input class="form-check-input" type="radio" name="role" value="{{ $role->id }}"
                                    id="role_{{ $role->id }}" @checked($isSelected)>
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->label }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('role')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3" id="staff-residence-field">
                <label for="residence_id" class="form-label">Assigned residence</label>
                <select name="residence_id" id="residence_id" class="form-select @error('residence_id') is-invalid @enderror">
                    <option value="">Select a residence</option>
                    @foreach ($residences as $residence)
                        <option value="{{ $residence->id }}" @selected((string) $selectedResidenceId === (string) $residence->id)>
                            {{ $residence->name }} - {{ $residence->city }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Required only when the selected role is Staff.</div>
                @error('residence_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
            </div>

        </form>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const staffRoleId = @json($staffRoleId);
                    const roleInputs = document.querySelectorAll('input[name="role"]');
                    const residenceField = document.getElementById('staff-residence-field');
                    const residenceSelect = document.getElementById('residence_id');

                    const toggleResidenceField = () => {
                        const selectedRole = document.querySelector('input[name="role"]:checked')?.value;
                        const shouldShow = staffRoleId && selectedRole === String(staffRoleId);

                        residenceField.classList.toggle('d-none', !shouldShow);

                        if (!shouldShow) {
                            residenceSelect.value = '';
                        }
                    };

                    roleInputs.forEach((input) => input.addEventListener('change', toggleResidenceField));
                    toggleResidenceField();
                });
            </script>
        @endpush

    </div>
@endsection
