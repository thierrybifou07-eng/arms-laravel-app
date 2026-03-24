@extends('layouts.app')

@section('content')
    <div class="card mb-6">
        <h5 class="card-header">Create Contract</h5>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body pt-4">
            <form id="formAccountSettings" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework"
                novalidate="novalidate" action="{{ route('contracts.store') }}">
                @csrf
                <div class="row g-6">
                    <div class="col-md-6">
                        <label for="student_id" class="form-label">Student</label>
                        <div class="position-relative"><select name="student_id" id="resident" class="select2 form-select"
                                tabindex="-1" aria-hidden="true">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->surname }} {{ $student->given_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="room">Room</label>
                        <div class="position-relative"><select name="room_id" id="room" class="select2 form-select">
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">Room {{ $room->number }} ({{ $room->rent }} FCFA)</option>
                                @endforeach
                            </select></div>
                    </div>
                    {{-- Billing Period --}}
                    <div class="col-md-6">
                        <label class="form-label" for="billing_period_id">Billing Period</label>
                        <div class="position-relative"><select name="billing_period_id" id="billing_period"
                                class="select2 form-select">
                                <option value="" disabled selected>Select Billing Period</option>
                                @foreach($billingPeriods as $billingPeriod)
                                    <option placeholder="Select billing period" value="{{ $billingPeriod->id }}">
                                        {{ $billingPeriod->label }}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="rent_amount">Amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="text" id="PhoneNumber" name="rent_amount" value="{{ old('rent_amount') }}"
                                class="form-control" placeholder="50000">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="start_date">Start date</label>
                        <div class="position-relative">
                            <input type="date" value="{{ old('start_date') }}" id="DateTime" name="start_date"
                                class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="end_date">End date</label>
                        <div class="position-relative">
                            <input type="date" id="DateTime" value="{{ old('end_date') }}" name="end_date"
                                class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">Create Contract</button>
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

document.getElementById('residence').addEventListener('change', function () {
    fetch(`/buildings/${this.value}`)
        .then(res => res.json())
        .then(data => {
            let buildingSelect = document.getElementById('building');
            buildingSelect.innerHTML = '<option>Select building</option>';

            data.forEach(b => {
                buildingSelect.innerHTML += `<option value="${b.id}">${b.name}</option>`;
            });
        });
}); 
        </script>
    @endpush
@endsection