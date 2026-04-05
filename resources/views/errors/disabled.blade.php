@extends('layouts.errors')
@section('content')

    <body>
        <!-- Content -->
        <!-- Error -->
        <div class="container-xxl container-p-y">
            <div class="misc-wrapper">
                <h1 class="mb-2 mx-2" style="line-height: 6rem; font-size: 6rem">403</h1>
                <h4 class="mb-2 mx-2">Your account is disabled</h4>
                <p class="mb-6 mx-2">Your account has been disabled. Please contact the administrator for more information.
                </p>
                <div class="mt-6">
                    <img src="{{ asset('admin-template/assets') }}/img/illustrations/girl-unlock-password-light.png"
                        alt="girl-unlock-password-light" width="500" class="img-fluid" />
                </div>
            </div>
        </div>
        <!-- /Error -->
    @endsection
