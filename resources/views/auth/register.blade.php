@extends('layouts.guest')

@section('content')
    <!-- /Logo -->
    <h4 class="mb-1">Adventure starts here 🚀</h4>
    <p class="mb-6">Make your app management easy and fun!</p>

    <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-6">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                value="{{ old('firstname') }}" required autocomplete="firstname" id="username" name="firstname"
                placeholder="Enter your firstname" autofocus />

            @error('firstname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-6">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                value="{{ old('lastname') }}" required autocomplete="lastname" id="username" name="lastname"
                placeholder="Enter your lastname" autofocus />

            @error('lastname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-6">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="string" class="form-control @error('phone') is-invalid @enderror" name="phone"
                value="{{ old('phone') }}" required autocomplete="phone" id="username" name="phone"
                placeholder="Enter your phone" autofocus />

            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div>
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
        <div class="form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-password-toggle">
            <label class="form-label" for="password-confirm">Confirm Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control"
                    name="password_confirmation" required
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="my-7">
            <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                <label class="form-check-label" for="terms-conditions">
                    I agree to
                    <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
            </div>
        </div>
        <button class="btn btn-primary d-grid w-100">Sign up</button>
    </form>

    <p class="text-center">
        <span>Already have an account?</span>
        <a href="{{ route('login') }}">
            <span>Sign in instead</span>
        </a>
    </p>
@endsection
