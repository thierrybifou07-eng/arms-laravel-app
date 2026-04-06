@extends('layouts.errors')
@section('error')
    <!-- Error -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h1 class="mb-2 mx-2" style="line-height: 6rem; font-size: 6rem">403</h1>
            <h4 class="mb-2 mx-2">Access denied</h4>
            <p class="mb-6 mx-2">You do not have any role to access this resource. Contact your administrator for more information.</p>
            <div class="mt-6">
                <img src="{{ asset('admin-template/assets') }}/img/illustrations/blocked.png"
                    alt="blocked" width="500" class="img-fluid" />
            </div>
        </div>
    </div>
    <!-- /Error -->
@endsection
