@extends('layouts.app')

@section('content')
    <div class="col-xxl col-lg-12 col-md-12 col-sm-12 py-4">

        <h1 class="h4 mb-3">
            Assign role to: {{ $user->lastname }} {{ $user->firstname }}
        </h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
            </div>

        </form>

    </div>
@endsection
