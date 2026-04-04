@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Bienvenue {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}! 🎉</h5>
                        <p class="mb-3">Vous êtes connecté en tant que <strong>{{ Auth::user()->roles->first()->name }}</strong></p>
                        <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                            <i class="icon-base bx bx-user me-1"></i> Vue Profil
                        </a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('admin-template/assets/img/illustrations/man-with-laptop.png') }}" height="175" alt="Welcome">
                    </div>
                </div>
            </div>
        </div>

        @include('dashboards.' . $role, $dashboardData ?? [])
    </div>
@endsection
