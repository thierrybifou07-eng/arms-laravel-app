@extends('layouts.app')

@section('content')
    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">

            <img src="{{ auth()->user()->avatar() }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded"
                id="uploadedAvatar">
            <form method="POST" action="{{ route('avatar.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-secondary me-3 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">New photo</span>
                        <input type="file" name="avatar" id="upload" class="account-file-input" hidden=""
                            accept="image/png, image/jpeg">
                    </label>
                    <button class="btn btn-primary account-image-reset mb-4">
                        <i class="icon-base bx bx-reset d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload</span>
                        <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                    </button>

                    <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                </div>
            </form>
        </div>
    </div>
@endsection