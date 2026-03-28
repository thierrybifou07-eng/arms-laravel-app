@extends('layouts.app')

@section('content')
    <div class="row fv-plugins-icon-container">
        <div class="col-md-12">
            <div class="card mb-6">
                @include('profile.partials.update-profile-information-form')
            </div>
            <div class="row g-12">
                <div class="col-lg-6">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="col-lg-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div> 
    </div>
@endsection
