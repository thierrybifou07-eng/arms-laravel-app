@extends('layouts.guestsite')
@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-slide">
            <div class="img overlay" style="background-image: url('{{ asset('property/images') }}/residence_1.jpg')"></div>
            <div class="img overlay" style="background-image: url('{{ asset('property/images') }}/file_0000000018e8720c9bbee667c8edf65d.png')"></div>
            <div class="img overlay" style="background-image: url('{{ asset('property/images') }}/university_4k0.jpeg')"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-9 text-center">
                    <h1 class="heading" data-aos="fade-up">
                        Smart Residence & Accommodation Management
                    </h1>
                    <p class="lead text-white mb-4" data-aos="fade-up" data-aos-delay="100">
                        Efficiently manage your residential properties, contracts, and payments all in one platform
                    </p>
                    @if (Route::has('login'))
                        @auth
                        @else
                            <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="200">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Sign In</a>
                                <a href="{{ route('register') }}" class="btn btn-light btn-lg">Get Started</a>
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Key Features Section -->
    <section class="features-1">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-lg-12">
                    <h2 class="font-weight-bold text-primary heading text-center mb-5">
                        Powerful Features for Complete Management
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="box-feature">
                        <span class="flaticon-building"></span>
                        <h3 class="mb-3">Building Management</h3>
                        <p>
                            Organize and manage multiple buildings with ease. Track floors, rooms, and occupancy status in real-time.
                        </p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="box-feature">
                        <span class="flaticon-house"></span>
                        <h3 class="mb-3">Residence Tracking</h3>
                        <p>
                            Complete visibility of all residences. Monitor status, residents, and property details effortlessly.
                        </p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
                    <div class="box-feature">
                        <span class="flaticon-house-3"></span>
                        <h3 class="mb-3">Contract Management</h3>
                        <p>
                            Create and manage residency contracts. Track dates, terms, and automatically generate payment schedules.
                        </p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
                    <div class="box-feature">
                        <span class="flaticon-house-1"></span>
                        <h3 class="mb-3">Payment Processing</h3>
                        <p>
                            Streamline payment collection and tracking. Support multiple payment methods and automated receipts.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <div class="section sec-testimonials">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-md-6">
                    <h2 class="font-weight-bold heading text-primary mb-4 mb-md-0">
                        What Our Users Say
                    </h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <div id="testimonial-nav">
                        <span class="prev" data-controls="prev">Prev</span>
                        <span class="next" data-controls="next">Next</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-slider-wrap">
                <div class="testimonial-slider">
                    <div class="item">
                        <div class="testimonial">
                            <div class="rate">
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                            </div>
                            <h3 class="h5 text-primary mb-4">Property Administrator</h3>
                            <blockquote>
                                <p>
                                    &ldquo;ARMS has completely transformed how we manage our residential complex. 
                                    Everything is organized and accessible from one dashboard. Highly recommended!&rdquo;
                                </p>
                            </blockquote>
                            <p class="text-black-50">Complex Manager, Multi-Building Housing</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="testimonial">
                            <div class="rate">
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                            </div>
                            <h3 class="h5 text-primary mb-4">Finance Manager</h3>
                            <blockquote>
                                <p>
                                    &ldquo;Payment tracking and financial reporting have never been easier. 
                                    The system is intuitive and saves us hours of work every week.&rdquo;
                                </p>
                            </blockquote>
                            <p class="text-black-50">Finance Officer, Student Housing Provider</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="testimonial">
                            <div class="rate">
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                                <span class="icon-star text-warning"></span>
                            </div>
                            <h3 class="h5 text-primary mb-4">Resident Services</h3>
                            <blockquote>
                                <p>
                                    &ldquo;Great system for managing resident information and service requests. 
                                    The transparency is appreciated by both staff and residents.&rdquo;
                                </p>
                            </blockquote>
                            <p class="text-black-50">Operations Director, Campus Housing</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose ARMS Section -->
    <div class="section section-4 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="font-weight-bold heading text-primary mb-4">
                        Why Choose ARMS?
                    </h2>
                    <p class="text-black-50">
                        ARMS is the comprehensive solution for all your residential property management needs. 
                        From student housing to residential complexes, manage everything with ease.
                    </p>
                </div>
            </div>
            <div class="row justify-content-between mb-5">
                <div class="col-lg-7 mb-5 mb-lg-0 order-lg-2">
                    <div class="img-about dots">
                        <img src="{{ asset('property/images') }}/university_4k.jpeg" alt="Management Dashboard" class="img-fluid rounded" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex feature-h">
                        <span class="wrap-icon me-3">
                            <i class="flaticon-check text-primary"></i>
                        </span>
                        <div class="feature-text">
                            <h3 class="heading">Role-Based Access</h3>
                            <p class="text-black-50">
                                Different access levels for administrators, staff, and residents.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex feature-h">
                        <span class="wrap-icon me-3">
                            <i class="flaticon-check text-primary"></i>
                        </span>
                        <div class="feature-text">
                            <h3 class="heading">Audit Trail</h3>
                            <p class="text-black-50">
                                Complete record of all changes for transparency and compliance.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex feature-h">
                        <span class="wrap-icon me-3">
                            <i class="flaticon-check text-primary"></i>
                        </span>
                        <div class="feature-text">
                            <h3 class="heading">Real-time Reports</h3>
                            <p class="text-black-50">
                                Generate instant reports on occupancy, payments, and more.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="section">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="font-weight-bold heading text-primary mb-4">
                        Comprehensive Management Platform
                    </h2>
                </div>
            </div>
            <div class="row section-counter">
                <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="counter-wrap mb-5 mb-lg-0">
                        <span class="number"><span class="countup text-primary">30+</span></span>
                        <span class="caption text-black-50">Database Tables</span>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="counter-wrap mb-5 mb-lg-0">
                        <span class="number"><span class="countup text-primary">15+</span></span>
                        <span class="caption text-black-50">Authorization Policies</span>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
                    <div class="counter-wrap mb-5 mb-lg-0">
                        <span class="number"><span class="countup text-primary">4</span></span>
                        <span class="caption text-black-50">Role-Based Dashboards</span>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
                    <div class="counter-wrap mb-5 mb-lg-0">
                        <span class="number text-primary"><span class="countup">100</span>%</span>
                        <span class="caption text-black-50">Secure & Audited</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Modules Section -->
    <div class="section bg-light">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="font-weight-bold heading text-primary mb-4">
                        Core System Modules
                    </h2>
                    <p class="text-black-50">
                        ARMS includes all the essential modules you need to manage residential properties efficiently
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Residential Management</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Buildings</li>
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Floors</li>
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Rooms</li>
                                <li><i class="flaticon-check text-success me-2"></i>Residences</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Contract & Billing</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Contracts</li>
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Billing Periods</li>
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Payment Methods</li>
                                <li><i class="flaticon-check text-success me-2"></i>Receipts</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Financial Management</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Payments</li>
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Payment History</li>
                                <li class="mb-2"><i class="flaticon-check text-success me-2"></i>Status Tracking</li>
                                <li><i class="flaticon-check text-success me-2"></i>Reports</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CTA Section -->
    <div class="section bg-light">
        <div class="row justify-content-center footer-cta" data-aos="fade-up">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="mb-4">Ready to streamline your residence management?</h2>
                <p class="text-black-50 mb-4">
                    Join thousands of property managers who trust ARMS for efficient accommodation and residence management.
                </p>
                @if (Route::has('login'))
                    @auth
                    @else
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('register') }}" class="btn btn-primary text-white py-3 px-5">Create Your Account</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary py-3 px-5">Sign In</a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </div>

@endsection
