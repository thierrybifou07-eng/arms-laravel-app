<div class="card h-100">
    <div class="card-header">{{ __('Update Password') }}</div>

    <div class="card-body">
        <div class="mb-3">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </div>
        <form id="formAccountSettings" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework"
            novalidate="novalidate" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <div class="row g-6">
                <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                    <label for="password" class="form-label">Current password</label>
                    <input class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" type="password" id="password"
                        name="current_password" required
                        autocomplete="current_password">
                    @error('current_password', 'updatePassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                    <label for="password" class="form-label">New password</label>
                    <input class="form-control @error('password', 'updatePassword') is-invalid @enderror" type="password" id="password"
                        name="password" required
                        autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                    <label for="password_confirmation" class="form-label">Confirm password</label>
                    <input class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" type="password" id="password_confirmation"
                        name="password_confirmation" required>
                    @error('password_confirmation', 'updatePassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary me-3">Save</button>
                @if (session('status') === 'password-updated')
                    <span class="m-1 fade-out">{{ __('Saved.') }}</span>
                @endif
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
            </div>
            <input type="hidden">
        </form>
    </div>
</div>
