@extends('layouts.guest')

@section('auth_inner_class', 'auth-register-wide')

@push('styles')
    <style>
        .auth-register-wide {
            max-width: 800px;
            width: 100%;
        }

        .auth-register-wide .iti,
        .auth-register-wide [data-phone-input] {
            width: 100%;
        }

        @media (min-width: 992px) {
            .auth-register-wide .card {
                padding-inline: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <h4 class="mb-1">Adventure starts here</h4>
    <p class="mb-6">Make your residence management easy, efficient, and enjoyable!</p>

    <form id="formAccountSetting" class="mb-6" method="POST" action="{{ route('register') }}" data-phone-form>
        @csrf

        <input type="hidden" name="phone" value="" data-phone-hidden>
        <input type="hidden" name="phone_country" value="{{ old('phone_country') }}" data-phone-country>

        <div class="row g-3">
            <div class="col-lg-6 col-md-6">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname"
                    name="firstname" value="{{ old('firstname') }}" placeholder="Enter your firstname" required
                    autocomplete="given-name" autofocus />

                @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-lg-6 col-md-6">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname"
                    name="lastname" value="{{ old('lastname') }}" placeholder="Enter your lastname" required
                    autocomplete="family-name" />

                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-lg-6 col-md-6">
                <label for="phone_display" class="form-label">Phone Number</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone_display"
                    name="phone_display" value="{{ old('phone') }}" placeholder="Enter your phone" required
                    autocomplete="tel-national" data-phone-input data-initial-country="{{ old('phone_country') }}" />

                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-lg-6 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email') }}" placeholder="Enter your email" required
                    autocomplete="email" />

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="form-password-toggle">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password_confirmation" class="form-control"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                    </div>
                </div>
            </div>

            <div class="my-3">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms"
                        @checked(old('terms')) />
                    <label class="form-check-label" for="terms-conditions">
                        I agree to
                        <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                </div>
            </div>

            <div class="d-none" id="SignUpContainer">
                <button id="SignUp" class="btn btn-primary d-grid w-100" type="submit">Sign up</button>
            </div>
        </div>
    </form>

    <p class="text-center">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}">
            <span>Sign in instead</span>
        </a>
    </p>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkbox = document.getElementById("terms-conditions");
            const passwordBox = document.getElementById("SignUpContainer");
            const activeSignUpBtn = document.getElementById("SignUp");

            if (!checkbox || !passwordBox || !activeSignUpBtn) {
                return;
            }

            const syncSignupState = () => {
                passwordBox.classList.toggle("d-none", !checkbox.checked);
                activeSignUpBtn.disabled = !checkbox.checked;
            };

            checkbox.addEventListener("change", function() {
                syncSignupState();
            });

            syncSignupState();
        });
    </script>
@endpush
