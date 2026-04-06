@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="user-profile-header-banner">
                        <img src="{{ asset('admin-template/assets') }}/img/pages/profile-banner.png" alt="Banner image"
                            class="rounded-top">
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-8">
                        <div class="flex-shrink-0 mt-1 mx-sm-0 mx-auto">
                            <img src="{{ asset('admin-template/assets') }}/img/avatars/1.png" alt="user image"
                                class="d-block h-auto ms-0 ms-sm-6 rounded-3 user-profile-img">
                        </div>
                        <div class="flex-grow-1 mt-3 mt-lg-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 mt-lg-7">
                                        {{ __('User Details: ' . $user->firstname . ' ' . $user->lastname) }}
                                    </h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 mt-4">
                                        <li class="list-inline-item"><i
                                                class="icon-base bx bx-palette me-2 align-top"></i><span
                                                class="fw-medium">{{ $user->role }}</span></li>
                                        <li class="list-inline-item"><i class="icon-base bx bx-map me-2 align-top"></i><span
                                                class="fw-medium">Address</span></li>
                                        <li class="list-inline-item"><i
                                                class="icon-base bx bx-calendar me-2 align-top"></i><span class="fw-medium">
                                                {{ $user->created_at }}</span></li>
                                    </ul>
                                </div>
                                <a href="javascript:void(0)" class="btn btn-primary mb-1"> <i
                                        class="icon-base bx bx-user-check icon-sm me-2"></i>{{ $user->status }} </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <!-- Navbar pills -->
        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-sm-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i
                                    class="icon-base bx bx-user icon-sm me-1_5"></i> Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-profile-teams.html"><i
                                    class="icon-base bx bx-group icon-sm me-1_5"></i> Resedence</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-profile-projects.html"><i
                                    class="icon-base bx bx-grid-alt icon-sm me-1_5"></i> Projects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-profile-connections.html"><i
                                    class="icon-base bx bx-link icon-sm me-1_5"></i> Connections</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Navbar pills -->

        <!-- User Profile Content -->
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5">
                <!-- About User -->
                <div class="card mb-6">
                    <div class="card-body">
                        <small class="card-text text-uppercase text-body-secondary small">About</small>
                        <ul class="list-unstyled my-3 py-1">
                            <li class="d-flex align-items-center mb-4"><i class="icon-base bx bx-user"></i><span
                                    class="fw-medium mx-2">Full Name:</span> <span>{{ $user->firstname }}
                                    {{ $user->lastname }}</span></li>
                            <li class="d-flex align-items-center mb-4"><i class="icon-base bx bx-check"></i><span
                                    class="fw-medium mx-2">Status:</span> <span>{{ $user->status }}</span></li>
                            <li class="d-flex align-items-center mb-4"><i class="icon-base bx bx-crown"></i><span
                                    class="fw-medium mx-2">Role:</span> <span>{{ $user->role }}</span></li>
                            <li class="d-flex align-items-center mb-4"><i class="icon-base bx bx-flag"></i><span
                                    class="fw-medium mx-2">Address:</span> <span>{{ $user->address }}</span></li>
                            <li class="d-flex align-items-center mb-2"><i class="icon-base bx bx-detail"></i><span>
                        </ul>
                        <small class="card-text text-uppercase text-body-secondary small">Contacts</small>
                        <ul class="list-unstyled my-3 py-1">
                            <li class="d-flex align-items-center mb-4"><i class="icon-base bx bx-phone"></i><span
                                    class="fw-medium mx-2">Contact:</span> <span>{{ $user->phone }}</span></li>
                            <li class="d-flex align-items-center mb-4"><i class="icon-base bx bx-chat"></i><span
                                    class="fw-medium mx-2">Skype:</span> <span>john.doe</span></li>
                            <li class="d-flex align-items-center mb-4"><i class="icon-base bx bx-envelope"></i><span
                                    class="fw-medium mx-2">Email:</span> <span>{{ $user->email }}</span></li>
                        </ul>
                    </div>
                </div>
                <!--/ About User -->
                <!-- Profile Overview -->
                <div class="card mb-6">
                    <div class="card-body">
                        <small class="card-text text-uppercase text-body-secondary small">Audit Logs</small>
                        <ul class="list-unstyled mb-0 mt-3 pt-1">
                            <li class="d-flex align-items-center mb-4"><i class="icon-base bx bx-check"></i><span
                                    class="fw-medium mx-2">Total Roles:</span> <span>{{ $user->roles->count() }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--/ Profile Overview -->
            </div>
        </div>
    </div>
    <!--/ User Profile Content -->
@endsection
