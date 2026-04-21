@extends('layouts.app')

@section('content')
    <div class="col-xxl-12">
        @include('dashboards.' . $role, $dashboardData ?? [])
    </div>
@endsection