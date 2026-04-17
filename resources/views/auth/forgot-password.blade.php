@extends('layouts.guest')

@section('content')
    <h4 class="mb-1">Forgot your password?</h4>
    <p class="mb-6">
        Enter your email address and we will send you a secure reset link so you can choose a new password.
    </p>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-6">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" placeholder="Enter your account email" required autocomplete="email"
                autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-6">
            <button type="submit" class="btn btn-primary d-grid w-100">
                Email Password Reset Link
            </button>
        </div>
    </form>

    <p class="text-center">
        <a href="{{ route('login') }}">
            <span>Back to login</span>
        </a>
    </p>
@endsection
