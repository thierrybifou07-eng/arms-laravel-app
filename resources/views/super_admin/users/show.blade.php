@extends('layouts.app')

@section('content')
    <div class="col-xxl col-lg-12 col-md-12 flex-grow-1">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row mb-2">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-2">
                    <div>
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary mb-2">
                            Back to Users
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        @if (auth()->id() !== $user->id && !$user->hasRole(\App\Models\Role::SUPER_ADMIN))
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
            <div class="col-lg-4 mb-4">
                @include('super_admin.users.partials.show.sidebar', [
                    'user' => $user,
                    'userRole' => $userRole,
                ])
            </div>

            <div class="col-lg-8">
                @include('super_admin.users.partials.show.role_access', [
                    'user' => $user,
                    'userRole' => $userRole,
                    'roleInsights' => $roleInsights,
                ])

                @include('super_admin.users.partials.show.account_overview', [
                    'user' => $user,
                ])

                @include('super_admin.users.partials.show.role_panels.' . $rolePanelView, [
                    'user' => $user,
                    'userRole' => $userRole,
                    'roleInsights' => $roleInsights,
                ])
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-hidden="true">
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
                                @forelse ($statusOptions as $status)
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
