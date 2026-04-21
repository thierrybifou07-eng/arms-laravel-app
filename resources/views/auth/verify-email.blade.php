@extends('layouts.guest')

@section('content')
    <!-- /Logo -->
    <h4 class="mb-1">Verify your email ✉️</h4>
    <p class="text-start mb-0">Account verification link sent to your email address: <span
            class="fw-medium text-heading">{{ auth()->user()->email }}</span> Please follow the link inside to continue.</p>
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success" role="alert">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif
    {{--     <a class="btn btn-primary w-100 my-6" href="index.html">Skip for now</a>
 --}} <p class="text-center mb-0">
        Didn't get the mail?
    <form class="" method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary w-100 my-6">
            Resend
        </button>
    </form>
    </p>
@endsection
