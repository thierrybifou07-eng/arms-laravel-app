@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Create a permission</h1>

    <form method="POST" action="{{ route('permissions.store') }}" class="card card-body">
        @csrf

        @include('permissions._form', ['permission' => null])

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection