<!-- Account -->
<div class="card-body">
    <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">

        <img src="{{ auth()->user()->avatar() }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded"
            id="uploadedAvatar">
        <form method="POST" action="{{ route('avatar.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="button-wrapper">
                <label for="upload" class="btn btn-secondary me-3 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">New photo</span>
                    <input type="file" name="avatar" id="upload" class="account-file-input" hidden=""
                        accept="image/png, image/jpeg">
                </label>
                <button class="btn btn-primary account-image-reset mb-4">
                    <i class="icon-base bx bx-reset d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Upload</span>
                    <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                </button>

                <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
            </div>
        </form>
    </div>
</div>

{{-- <form method="POST" action="{{ route('avatar.update') }}" enctype="multipart/form-data">
    @csrf

    <img src="{{ auth()->user()->avatar() }}" alt="" class="rounded-circle">

    <input type="file" name="avatar" class="form-control mt-3">

    <button class="btn btn-primary mt-3">
        Upload
    </button>

</form> --}}

<div class="card-body pt-4">
    <form id="send-verification" class="d-none" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form id="formAccountSettings" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework"
        novalidate="novalidate" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div class="row g-6">
            <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                <label for="firstname" class="form-label">First Name</label>
                <input class="form-control @error('firstname') is-invalid @enderror" type="text" id="firstName"
                    name="firstname" value="{{ old('firstname', $user->firstname) }}" autofocus="" required
                    autocomplete="firstname">
                @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
            </div>
            <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                <label for="lastname" class="form-label">Last Name</label>
                <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname"
                    id="lastname" value="{{ old('lastname', $user->lastname) }}" required autocomplete="lastname">
                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="phone">Phone Number</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">(+237)</span>
                    <input type="phone" id="phoneNumber" name="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $user->phone) }}" required autocomplete="phone">
                </div>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email"
                    value="{{ old('email', $user->email) }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="mb-0">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="btn btn-link p-0">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success mt-3 mb-0" role="alert">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>

        </div>
        <div class="mt-6">
            <button type="submit" class="btn btn-primary me-3">Save changes</button>
            @if (session('status') === 'profile-updated')
                <span class="m-1 fade-out">{{ __('Saved.') }}</span>
            @endif
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
        </div>
        <input type="hidden">
    </form>
</div>
<!-- /Account -->