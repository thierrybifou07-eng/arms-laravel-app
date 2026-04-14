@extends('layouts.app')

@section('content')
<div class="col-xxl col-lg-12 col-md-12 col-sm-12 py-4">
    <h1 class="h4 mb-3">Activate the user</h1>

    <div class="card shadow-sm p-4 mb-4">
        <p class="mb-1"><strong>Name :</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
        <p class="mb-1"><strong>Email :</strong> {{ $user->email }}</p>
        <p class="mb-1"><strong>Phone :</strong> {{ $user->phone }}</p>
        <p class="mb-0"><strong>Current status :</strong> {{ $user->userStatus?->label ?? 'Pending' }}</p>
    </div>

    <form method="POST" action="{{ route('activate_accountpending_users.update', $user) }}" class="card shadow-sm p-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label d-block">Select a role</label>

            <div class="row">
                @foreach($roles as $role)
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            @php
                                $userRole = $user->getRole();
                                $isSelected = $userRole && $userRole->id === $role->id;
                            @endphp
                            <input class="form-check-input"
                                   type="radio"
                                   name="role"
                                   value="{{ $role->id }}"
                                   id="role_{{ $role->id }}"
                                   @checked($isSelected)
                                   required>
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

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Activate
            </button>
            <a href="{{ route('activate_accountpending_users.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection