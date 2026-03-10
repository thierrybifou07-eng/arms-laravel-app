@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xxl-8 mb-6 order-0">
                    <!-- body-wrapper-->

                    <div class="card">
                        <h5 class="card-header">Bootstrap Validation</h5>
                        <div class="card-body">
                            <form class="needs-validation" novalidate="" method="POST" action="{{ route('dashboard') }}">
                                @csrf
                                <div class="mb-6">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="bs-validation-name"
                                        placeholder="John Doe" required="" name="name">
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter the residence name.</div>
                                </div>
                                <div class="mb-6">
                                    <label class="form-label" for="address">Addresse</label>
                                    <input type="text" id="bs-validation-email" name="address" class="form-control"
                                        placeholder="john.doe" aria-label="john.doe" required="">
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter a valid email</div>
                                </div>
                                <div class="mb-6 form-password-toggle">
                                    <label class="form-label" for="address">Capacity</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="bs-validation-password" class="form-control"
                                            placeholder="············" required="" name="capacity">
                                        <span class="input-group-text cursor-pointer" id="basic-default-password4"><i
                                                class="icon-base bx bx-hide"></i></span>
                                    </div>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter The Capacity</div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- / body-wrapper-->
                </div>
            </div>
        </div>
        <!-- / Content -->
    </div>
@endsection
