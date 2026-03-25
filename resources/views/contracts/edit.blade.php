@extends('layouts.app')
@section('content')
    <div class="card mb-6">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h5 class="card-header">Update Contract</h5>
        <div class="card-body pt-4">
            <form id="formAccountSettings" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework"
                novalidate="novalidate" action="{{ route('contracts.update', $contracts->id) }}">
                @method('PUT')
                @csrf
                {{-- Student --}}
                <div class="row g-6">
                    <div class="col-md-6">
                        <label for="student_id" class="form-label">Student</label>
                        <div class="position-relative">
                            <select name="student_id" id="resident" class="select2 form-select" tabindex="-1"
                                aria-hidden="true" required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ $contracts->student_id == $student->id ? 'selected' : ''
                                            }}>
                                        {{ $student->surname }} {{ $student->given_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Room --}}
                    <div class="col-md-6">
                        <label class="form-label" for="room_id">Room</label>
                        <div class="position-relative">
                            <select name="room_id" id="room" class="select2 form-select">
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $contracts->room_id == $room->id ? 'selected' : '' }}>
                                        Room {{ $room->number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Billing Period --}}
                    <div class="col-md-6">
                        <label class="form-label" for="billing_period_id">Billing Period</label>
                        <div class="position-relative"><select name="billing_period_id" id="billing_period"
                                class="select2 form-select">
                                @foreach($billingPeriods as $billingPeriod)
                                    <option placeholder="Select billing period" value="{{ $billingPeriod->id }}">
                                        {{$contracts->billing_period_id == $billingPeriod->id ? 'selected' : '' }}
                                        {{ $billingPeriod->label }}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                    {{-- Dates --}}
                    <div class="col-md-6">
                        <label class="form-label" for="start_date">Start date</label>
                        <div class="position-relative">
                            <input type="date" value="{{ $contracts->start_date }}" id="DateTime" name="start_date"
                                class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="end_date">End date</label>
                        <div class="position-relative">
                            <input type="date" value="{{ $contracts->end_date }}" id="DateTime" name="end_date"
                                class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">Update Contract</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                    <input type="hidden">
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            console.log($.fn.select2);
            console.log("Select2 init");
            $(document).ready(function () {

                $('#resident').select2({
                    placeholder: "Select resident",
                    allowClear: true,
                    width: '100%'
                });

                $('#room').select2({
                    placeholder: "Select room",
                    allowClear: true,
                    width: '100%'
                });

                /*                  $('#billing_period').select2({
                                    placeholder: "Select billing period",
                                    allowClear: true,
                                    width: '100%'
                                }); */
            });

        </script>
    @endpush
@endsection