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
                        <div class="position-relative"><select name="student_id" id="student_id" class="select2 form-select"
                                tabindex="-1" aria-hidden="true">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user_id->firstname }} {{ $student->user_id->lastname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Select residence
                    --}}<div class="col-md-6">
                        <label class="form-label">Residence</label>
                        <select id="residence" class="select2 form-select">
                            <option value="">Select residence</option>
                            @foreach(\App\Models\Residence::all() as $residence)
                                <option value="{{ $residence->id }}">{{ $residence->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Building</label>
                        <select id="building" class="select2 form-select"></select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Floor</label>
                        <select id="floor" class="select2 form-select"></select>
                    </div>
                    {{-- Select residence
                    --}} <div class="col-md-6">
                        <label class="form-label">Room</label>
                        <div class="position-relative"><select id="room_id" name="room_id"
                                class="select2 form-select"></select>
                        </div>
                    </div>

                    {{-- Auto calcul total rent_amount
                    --}} <div class="col-md-6">
                        <label class="form-label" for="start_date">Start date</label>
                        <div class="position-relative">
                            <input type="date" value="{{ old('start_date') }}" id="start_date" name="start_date"
                                class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="end_date">End date</label>
                        <div class="position-relative">
                            <input type="date" id="end_date" value="{{ old('end_date') }}" name="end_date"
                                class="form-control" placeholder="" required>
                        </div>
                    </div>
                    {{-- Billing Period --}}
                    <div class="col-md-6">
                        <label class="form-label" for="billing_period_id">Billing Period</label>
                        <div class="position-relative"><select name="billing_period_id" id="billing_period"
                                class="select2 form-select">
                                <option value="" disabled selected>Select Billing Period</option>
                                @foreach($billingPeriods as $billingPeriod)
                                    <option value="{{ $billingPeriod->id }}" data-code="{{ $billingPeriod->code }}">
                                        {{ $billingPeriod->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Calculated Amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="text" id="calculated_amount" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Payment Schedule Preview</label>
                        <ul id="payment_schedule" class="list-group"></ul>
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
        <script>$(document).ready(function () {
                $('#student_id, #residence, #building, #floor, #room_id, #billing_period')
                    .select2({ width: '100%', placeholder: 'Select option' });

                $('#residence').on('change', function () {
                    let id = $(this).val();
                    $('#building, #floor, #room_id').empty().trigger('change');

                    fetch(`/buildings/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option></option>';
                            data.forEach(b => {
                                options += `<option value="${b.id}">${b.name}</option>`;
                            });
                            $('#building').html(options).trigger('change');
                        });
                });

                $('#building').on('change', function () {
                    let id = $(this).val();
                    $('#floor, #room_id').empty().trigger('change');

                    fetch(`/floors/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option></option>';
                            data.forEach(f => {
                                options += `<option value="${f.id}">Floor ${f.number}</option>`;
                            });
                            $('#floor').html(options).trigger('change');
                        });
                });

                $('#floor').on('change', function () {
                    let id = $(this).val();
                    $('#room_id').empty().trigger('change');

                    fetch(`/rooms/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option></option>';
                            data.forEach(r => {
                                options += `<option value="${r.id}" data-rent="${r.rent}">Room ${r.number} - ${r.rent} FCFA</option>`;
                            });
                            $('#room_id').html(options).trigger('change');
                        });
                });

                $('#room_id, #billing_period, #start_date, #end_date')
                    .on('change select2:select', function () {
                        calculateAmount();
                        generateSchedulePreview();
                    });

                function getBillingCode() {
                    return $('#billing_period option:selected').data('code') || '';
                }

                function calculateAmount() {
                    const rent = parseFloat($('#room_id option:selected').data('rent')) || 0;
                    const code = getBillingCode();
                    const startDate = $('#start_date').val();
                    const endDate = $('#end_date').val();

                    if (!rent || !code || !startDate || !endDate) {
                        $('#calculated_amount').val('');
                        return;
                    }

                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const months = monthDiff(start, end);

                    let amount = 0;

                    switch (code) {
                        case 'once':
                            amount = rent * (months);
                            break;
                        case 'monthly':
                            amount = rent;
                            break;
                        case 'quarterly':
                            amount = rent * 3;
                            break;
                        case 'half_yearly':
                            amount = rent * 6;
                            break;
                        case 'yearly':
                            amount = rent * 12;
                            break;
                        default:
                            amount = rent;
                    }

                    $('#calculated_amount').val(amount);
                }

                function generateSchedulePreview() {
                    const startDate = $('#start_date').val();
                    const endDate = $('#end_date').val();
                    const rent = parseFloat($('#room_id option:selected').data('rent')) || 0;
                    const code = getBillingCode();

                    if (!startDate || !endDate || !rent || !code) {
                        $('#payment_schedule').html('');
                        return;
                    }

                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const totalMonths = monthDiff(start, end);

                    let html = '';

                    if (code === 'once') {
                        const totalAmount = rent * totalMonths;

                        html = `
                        <li class="list-group-item d-flex justify-content-between">
                            <span>${formatDate(start)}</span>
                            <strong>${totalAmount} FCFA</strong>
                        </li>
                    `;

                        $('#payment_schedule').html(html);
                        return;
                    }

                    let interval = 1;
                    if (code === 'monthly') interval = 1;
                    if (code === 'quarterly') interval = 3;
                    if (code === 'half_yearly') interval = 6;
                    if (code === 'yearly') interval = 12;

                    let current = new Date(start);

                    while (current <= end) {
                        html += `
                        <li class="list-group-item d-flex justify-content-between">
                            <span>${formatDate(current)}</span>
                            <strong>${rent * interval} FCFA</strong>
                        </li>
                    `;
                        current.setMonth(current.getMonth() + interval);
                    }

                    $('#payment_schedule').html(html);
                }

                function formatDate(date) {
                    return date.toISOString().split('T')[0];
                }

                function monthDiff(start, end) {
                    let months =
                        (end.getFullYear() - start.getFullYear()) * 12 +
                        (end.getMonth() - start.getMonth());

                    return months <= 0 ? 1 : months;
                }
            });

        </script>
    @endpush
@endsection