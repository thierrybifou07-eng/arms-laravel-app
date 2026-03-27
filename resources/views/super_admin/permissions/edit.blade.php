@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Edit the permission</h1>

    <form method="POST" action="{{ route('permissions.update', $permission) }}" class="card card-body">
        @csrf
        @method('PUT')

        @include('super_admin.permissions._form', ['permission' => $permission])

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@endsection