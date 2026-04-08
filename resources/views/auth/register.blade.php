@extends('layouts.guest')

@section('content')
    <!-- /Logo -->
    <h4 class="mb-1">Adventure starts here</h4>
    <p class="mb-6">Make your residence management easy, efficient, and enjoyable!</p>
    <form id="formAccountSetting" class="mb-6" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row g-3">
            <div class="col-lg-6 col-md-6 form-control-validation fv-plugins-icon-container">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                    value="{{ old('firstname') }}" required autocomplete="firstname" id="firstname" name="firstname"
                    placeholder="Enter your firstname" autofocus />

                @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
            </div>

            <div class="col-lg-6 col-md-6 form-control-validation fv-plugins-icon-container">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                    value="{{ old('lastname') }}" required autocomplete="lastname" id="lastname" name="lastname"
                    placeholder="Enter your lastname" autofocus />

                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone"
                    value="{{ old('phone') }}" required autocomplete="phone" id="phone" name="phone"
                    placeholder="Enter your phone" autofocus />
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" id="email" name="email"
                    placeholder="Enter your email" />
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
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password"
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
                    <label class="form-label" for="password-confirm">Confirm Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password_confirmation" required
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
            <div class="my-3">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                        I agree to
                        <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                </div>
            </div>
            <div class="d-none" id="SignUpContainer">
                <button id="SignUp" class="btn btn-primary d-grid w-100">Sign up</button>
            </div>
        </div>
    </form>

    <p class="text-center">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}">
            <span>Sign in instead</span>
        </a>
    </p>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const checkbox = document.getElementById("terms-conditions");
            const passwordBox = document.getElementById("SignUpContainer");
            const ActiveSignUpBtn = document.getElementById("SignUp");

            if (!checkbox) return;

            checkbox.addEventListener("change", function() {

                if (checkbox.checked) {
                    passwordBox.classList.remove("d-none")

                    ActiveSignUpBtn.disabled = false;

                } else {
                    passwordBox.classList.add("d-none")

                    ActiveSignUpBtn.disabled = true;

                }

            });

        });
    </script>
@endsection
